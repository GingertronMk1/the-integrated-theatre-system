<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\TrainingItem\CreateTrainingItem\Command as CreateCommand;
use App\Application\TrainingItem\CreateTrainingItem\CommandHandler as CreateCommandHandler;
use App\Application\TrainingItem\TrainingItemFinderInterface;
use App\Application\TrainingItem\UpdateTrainingItem\Command as UpdateCommand;
use App\Application\TrainingItem\UpdateTrainingItem\CommandHandler as UpdateCommandHandler;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use App\Framework\Form\TrainingItemType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TrainingItemController extends AbstractController
{
    #[Route('/training-item', 'training-item.index', methods: ['GET'])]
    public function index(Request $request, TrainingItemFinderInterface $finder): Response
    {
        $categories = $finder->findAll();

        return $this->render(
            'pages/training-item/index.html.twig',
            [
                'training_categories' => $categories,
            ]
        );
    }

    #[Route('/training-item/create', 'training-item.create', methods: ['GET', 'POST'])]
    public function create(Request $request, CreateCommandHandler $handler): Response
    {
        $command = new CreateCommand();
        $form = $this->createForm(TrainingItemType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Created training item');

                $returnRoute = $request->get('return_to', 'training-item.index');

                return $this->redirectToRoute($returnRoute);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $this->render('pages/training-item/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/training-item/update/{id}', 'training-item.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id, UpdateCommandHandler $handler, TrainingItemFinderInterface $finder): Response
    {
        $item = $finder->find(TrainingItemId::fromString($id));
        $command = UpdateCommand::forItem($item);
        $form = $this->createForm(TrainingItemType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Updated training item');

                $returnRoute = $request->get('return_to', 'training-item.index');

                return $this->redirectToRoute($returnRoute);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $this->render('pages/training-item/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
