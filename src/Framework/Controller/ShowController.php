<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\Show\CreateShow\Command as CreateCommand;
use App\Application\Show\CreateShow\CommandHandler as CreateCommandHandler;
use App\Application\Show\ShowFinderInterface;
use App\Application\Show\UpdateShow\Command as UpdateCommand;
use App\Application\Show\UpdateShow\CommandHandler as UpdateCommandHandler;
use App\Domain\Show\ValueObject\ShowId;
use App\Framework\Form\ShowType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowController extends AbstractController
{
    #[Route('/show', 'show.index', methods: ['GET'])]
    public function index(ShowFinderInterface $finder): Response
    {
        $shows = $finder->findAll();

        return $this->render(
            'pages/show/index.html.twig',
            [
                'shows' => $shows,
            ]
        );
    }

    #[Route('/show/create', 'show.create', methods: ['GET', 'POST'])]
    public function create(Request $request, CreateCommandHandler $handler): Response
    {
        $command = new CreateCommand();
        $form = $this->createForm(ShowType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($command);

            return $this->redirectToRoute('show.index');
        }

        return $this->render(
            'pages/show/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/show/update/{id}', 'show.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id, UpdateCommandHandler $handler, ShowFinderInterface $finder): Response
    {
        $show = $finder->find(ShowId::fromString($id));
        $command = UpdateCommand::forShow($show);
        $form = $this->createForm(ShowType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($command);

            return $this->redirectToRoute('show.index');
        }

        return $this->render(
            'pages/show/update.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
