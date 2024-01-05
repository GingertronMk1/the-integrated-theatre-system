<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CrewRoleController extends AbstractController
{
    #[Route('/crew-role', 'crew-role.index', methods: ['GET'])]
    public function index(): Response
    {
        $items = [];

        return $this->render(
            'pages/crew-role/index.html.twig',
            [
                'items' => $items,
            ]
        );
    }

    #[Route('/crew-role/create', 'crew-role.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        return $this->render('pages/crew-role/create.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }

    #[Route('/crew-role/update/{id}', 'crew-role.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id): Response
    {
        return $this->render('pages/crew-role/update.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }
}
