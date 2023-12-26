<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\TrainingCategory\CreateTrainingCategory\Command as CreateCommand;
use App\Application\TrainingCategory\CreateTrainingCategory\CommandHandler as CreateCommandHandler;
use App\Application\TrainingCategory\UpdateTrainingCategory\Command as UpdateCommand;
use App\Application\TrainingCategory\UpdateTrainingCategory\CommandHandler as UpdateCommandHandler;
use App\Domain\TrainingCategory\TrainingCategoryFinderInterface;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Framework\Form\TrainingCategoryType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TrainingCategoryController extends AbstractController
{
    #[Route('/training-category', 'training-category.index', methods: ['GET'])]
    public function index(TrainingCategoryFinderInterface $finder): Response
    {
        $categories = $finder->findAll();

        return $this->render(
            'pages/training-category/index.html.twig',
            [
                'training_categories' => $categories,
            ]
        );
    }

    #[Route('/training-category/create', 'training-category.create', methods: ['GET', 'POST'])]
    public function create(Request $request, CreateCommandHandler $handler): Response
    {
        $command = new CreateCommand();
        $form = $this->createForm(TrainingCategoryType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Created training category');

                $returnRoute = $request->get('return_to', 'training-category.index');

                return $this->redirectToRoute($returnRoute);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $this->render('pages/training-category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/training-category/update/{id}', 'training-category.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id, UpdateCommandHandler $handler, TrainingCategoryFinderInterface $finder): Response
    {
        $category = $finder->find(TrainingCategoryId::fromString($id));
        $command = UpdateCommand::forCategory($category);
        $form = $this->createForm(TrainingCategoryType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Updated training category');

                $returnRoute = $request->get('return_to', 'training-category.index');

                return $this->redirectToRoute($returnRoute);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $this->render('pages/training-category/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
