<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CrewMemberController extends AbstractController
{
    #[Route('crew-member', 'crew-member.index', methods: ['GET'])]
    public function index(): Response
    {
        $items = [];

        return $this->render(
            'pages/crew-member/index.html.twig',
            [
                'training_items' => $items,
            ]
        );
    }

    #[Route('/crew-member/create', 'crew-member.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        return $this->render('pages/crew-member/create.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }

    #[Route('/crew-member/update/{id}', 'crew-member.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id): Response
    {
        return $this->render('pages/crew-member/update.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }
}
