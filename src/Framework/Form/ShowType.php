<?php

declare(strict_types=1);

namespace App\Framework\Form;

use App\Application\Common\Service\ClockInterface;
use App\Application\Season\SeasonFinderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ShowType extends AbstractType
{
    public function __construct(
        private readonly ClockInterface $clock,
        private readonly SeasonFinderInterface $seasonFinder
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $years = [];
        foreach (range(1966, $this->clock->getCurrentTime()->getYear()) as $year) {
            $strYear = (string) $year;
            $years[$strYear] = $strYear;
        }

        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class, ['required' => false])
            ->add(
                'year',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => $years,
                    'choice_label' => fn (?string $str) => $str ?? 'Unknown',
                ])
            ->add('semester', TextType::class, ['required' => false])
            ->add(
                'season',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => $this->seasonFinder->findAll(),
                    'choice_label' => 'name',
                    'choice_value' => 'id',
                ]
            )
            ->add('submit', SubmitType::class)
        ;
    }
}
