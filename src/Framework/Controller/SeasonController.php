<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\Season\CreateSeason\Command as CreateCommand;
use App\Application\Season\CreateSeason\CommandHandler as CreateCommandHandler;
use App\Application\Season\SeasonFinderInterface;
use App\Application\Season\UpdateSeason\Command as UpdateCommand;
use App\Application\Season\UpdateSeason\CommandHandler as UpdateCommandHandler;
use App\Domain\Season\ValueObject\SeasonId;
use App\Framework\Form\SeasonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SeasonController extends AbstractController
{
    #[Route('/season', 'season.index', methods: ['GET'])]
    public function index(SeasonFinderInterface $finder): Response
    {
        $seasons = $finder->findAll();

        return $this->render('pages/season/index.html.twig', ['seasons' => $seasons]);
    }

    #[Route('/season/create', 'season.create', methods: ['GET', 'POST'])]
    public function create(Request $request, CreateCommandHandler $handler): Response
    {
        $command = new CreateCommand();
        $form = $this->createForm(SeasonType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($command);

            return $this->redirectToRoute('season.index');
        }

        return $this->render(
            'pages/season/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/season/update/{id}', 'season.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id, UpdateCommandHandler $handler, SeasonFinderInterface $finder): Response
    {
        $show = $finder->find(SeasonId::fromString($id));
        $command = UpdateCommand::forSeason($show);
        $form = $this->createForm(SeasonType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($command);

            return $this->redirectToRoute('season.index');
        }

        return $this->render(
            'pages/season/update.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
