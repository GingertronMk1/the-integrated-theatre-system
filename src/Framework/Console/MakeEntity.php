<?php

declare(strict_types=1);

namespace App\Framework\Console;

use App\Domain\Common\ValueObject\AbstractUuidId;
use Doctrine\DBAL\Connection;
use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

#[AsCommand(
    name: 'app:make-entity',
    description: 'Creates a new entity',
)]
final class MakeEntity extends Command
{
    private const ARG_CLASSNAME = 'className';
    private const OPT_DRY_RUN = 'dry-run';

    private const KIND_INTERFACE = 'interface';
    private const KIND_CLASS = 'class';
    private const KIND_DIRECTORY = 'dir';

    private const CLASSNAME_PLACEHOLDER = '<className>';

    private string $className = '';
    private bool $dryRun = false;
    private SymfonyStyle $io;
    private readonly Inflector $inflector;

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly Environment $twig,
    ) {
        $this->inflector = InflectorFactory::create()->build();
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                self::ARG_CLASSNAME,
                InputArgument::REQUIRED,
                'The name of the class'
            )
            ->addOption(
                self::OPT_DRY_RUN,
                'd',
                InputOption::VALUE_NONE,
                'Add to not actually write any files'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->dryRun = (bool) $input->getOption(self::OPT_DRY_RUN);
        $this->className = $input->getArgument(self::ARG_CLASSNAME);
        $this->io->note($this->dryRun ? 'Dry Run' : 'Not a Dry Run');
        foreach ($this->getPlacesAndThings() as $place => $things) {
            $this->generatePlace($place, $things);
        }

        $this->makeTwigFiles();

        return self::SUCCESS;
    }

    /**
     * @param array<string, mixed> $things
     */
    private function generatePlace(
        string $place,
        array $things
    ): void {
        $place = str_replace(self::CLASSNAME_PLACEHOLDER, $this->className, $place);
        $dirName = $this->kernel->getProjectDir()."/src/{$place}";
        $this->io->section($dirName);
        $nameSpace = 'App\\'.str_replace('/', '\\', $place);
        if (!$this->dryRun) {
            if (!is_dir($dirName)) {
                mkdir($dirName, recursive: true);
            } else {
            }
        } else {
        }
        foreach ($things as $thing => $attrs) {
            $kind = $attrs['kind'] ?? self::KIND_CLASS;
            $this->io->text("{$place}/{$thing}: {$kind}");
            if (self::KIND_DIRECTORY === $kind) {
                $this->generatePlace("{$place}/{$thing}", $attrs['items'] ?? []);
            } else {
                $this->generateThing(
                    $thing,
                    $attrs,
                    $dirName,
                    $nameSpace
                );
            }
        }
    }

    /**
     * @param array<string, mixed> $attrs
     */
    private function generateThing(
        string $thing,
        array $attrs,
        string $dirName,
        string $nameSpace,
    ): void {
        $thing = str_replace(self::CLASSNAME_PLACEHOLDER, $this->className, $thing);
        $qualifiedFileName = "{$dirName}/{$thing}.php";
        $kind = $attrs['kind'] ?? self::KIND_CLASS;
        $content = $this->twig->render(
            'util/make-entity.php.twig',
            [
                'nameSpace' => $nameSpace,
                'className' => $thing,
                'kind' => $kind,
                'comment' => $attrs['comment'] ?? null,
                'attributes' => $attrs['attributes'] ?? [],
                'extends' => $attrs['extends'] ?? [],
                'implements' => $attrs['implements'] ?? []
            ]
        );
        if (!$this->dryRun) {
            if (!file_exists($qualifiedFileName)) {
                $fp = fopen($qualifiedFileName, 'w');
                fwrite(
                    $fp,
                    $content
                );
            } else {
            }
        } else {
        }
    }

    /**
     * @return array<string, array<mixed>>
     */
    private function getPlacesAndThings(): array
    {
        $classPlaceholder = self::CLASSNAME_PLACEHOLDER;
        return [
            "Domain/{$classPlaceholder}" => [
                "{$classPlaceholder}Entity" => [],
                "{$classPlaceholder}FinderInterface" => [
                    "kind" => self::KIND_INTERFACE,
                ],
                "ValueObject" => [
                    "kind" => "dir",
                    "items" => [
                        "{$classPlaceholder}Id" => [
                            'extends' => AbstractUuidId::class
                        ],
                    ],
                ],
            ],
            "Application/{$classPlaceholder}" => [
                "{$classPlaceholder}Model" => [],
                "{$classPlaceholder}RepositoryInterface" => [
                    "kind" => self::KIND_INTERFACE,
                ],
                "Create{$classPlaceholder}" => [
                    'kind' => self::KIND_DIRECTORY,
                    'items' => [
                        'Command' => [],
                        'CommandHandler' => []
                    ]
                ],
                 "Update{$classPlaceholder}" => [
                    'kind' => self::KIND_DIRECTORY,
                    'items' => [
                        'Command' => [],
                        'CommandHandler' => []
                    ]
                ],
            ],
            "Infrastructure/{$classPlaceholder}" => [
                "Dbal{$classPlaceholder}Repository" => [
                    'attributes' => [
                        Connection::class => 'private readonly'
                    ]
                ],
                "Dbal{$classPlaceholder}Finder" => [
                                        'attributes' => [
                        Connection::class => 'private readonly'
                    ]],
            ],
            "Framework" => [
                "Controller" => [
                    "kind" => "dir",
                    "items" => [
                        "{$classPlaceholder}Controller" => [
                            'extends' => AbstractController::class
                        ],
                    ],
                ],
                "Form" => [
                    "kind" => "dir",
                    "items" => [
                        "{$classPlaceholder}Type" => [
                            'extends' => AbstractType::class
                        ],
                    ],
                ],
            ],
        ];
    }

    private function makeTwigFiles(): void
    {
        $kebabClass = str_replace('_', '-', $this->inflector->camelize($this->className));
        $dir = $this->kernel->getProjectDir().'/templates/pages/'.$kebabClass;
        if (!is_dir($dir)) {
            mkdir($dir, recursive: true);
        }
        foreach ([
            'index',
            'create',
            'view',
            'edit',
        ] as $view) {
            $fileName = "{$dir}/{$view}.html.twig";
            if (!file_exists($fileName)) {
                $fp = fopen($fileName, 'w');
                fwrite(
                    $fp,
                    <<<TWIG
{% extends 'layouts/base.html.twig' %}

{% block body %}
{% endblock %}
TWIG
                );
                fclose($fp);
            }
        }
    }
}
