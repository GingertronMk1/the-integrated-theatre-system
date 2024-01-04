<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CrewMemberController extends AbstractController
{
    #[Route('<NAME>', '<NAME>.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render(
            'pages/<NAME>/index.html.twig',
            [
                'training_items' => $items,
            ]
        );
    }

    #[Route('/<NAME>/create', '<NAME>.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        return $this->render('pages/<NAME>/create.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }

    #[Route('/<NAME>/update/{id}', '<NAME>.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id): Response
    {
        return $this->render('pages/<NAME>/update.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }
}
