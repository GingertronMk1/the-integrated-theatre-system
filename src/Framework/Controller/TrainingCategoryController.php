<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\TrainingCategory\CreateTrainingCategoryCommand;
use App\Application\TrainingCategory\CreateTrainingCategoryCommandHandler;
use App\Domain\TrainingCategory\TrainingCategoryFinderInterface;
use App\Framework\Form\TrainingCategoryType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TrainingCategoryController extends AbstractController
{
    #[Route('/training-category', 'training-category.index', methods: ['GET'])]
    public function index(Request $request, TrainingCategoryFinderInterface $finder): Response
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
    public function create(Request $request, CreateTrainingCategoryCommandHandler $handler): Response
    {
        $command = new CreateTrainingCategoryCommand();
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
}
