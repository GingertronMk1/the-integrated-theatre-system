<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\CastMember\CreateCastMember\Command as CreateCommand;
use App\Application\CastMember\CreateCastMember\CommandHandler;
use App\Application\Show\ShowFinderInterface;
use App\Domain\Show\ValueObject\ShowId;
use App\Framework\Form\CastMemberType;
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

    #[Route('/cast-member/create/{showId}', 'cast-member.create', methods: ['POST'])]
    public function create(Request $request, string $showId, CommandHandler $handler, ShowFinderInterface $finder): Response
    {
        $show = $finder->find(ShowId::fromString($showId));
        $command = CreateCommand::forShow($show);
        $form = $this->createForm(CastMemberType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($command);
        }
        return $this->redirectToRoute('show.show', ['id' => $show->id]);
    }

    #[Route('/cast-member/update/{id}', 'cast-member.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id): Response
    {
        return $this->render('pages/cast-member/update.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }
}
