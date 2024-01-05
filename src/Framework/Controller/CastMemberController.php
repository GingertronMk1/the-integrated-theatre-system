<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CastMemberController extends AbstractController
{
    #[Route('/cast-member', 'cast-member.index', methods: ['GET'])]
    public function index(): Response
    {
        $items = [];

        return $this->render(
            'pages/cast-member/index.html.twig',
            [
                'items' => $items,
            ]
        );
    }

    #[Route('/cast-member/create', 'cast-member.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        return $this->render('pages/cast-member/create.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }

    #[Route('/cast-member/update/{id}', 'cast-member.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id): Response
    {
        return $this->render('pages/cast-member/update.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }
}
