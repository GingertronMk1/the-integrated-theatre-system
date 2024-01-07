<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\CrewMember\CreateCrewMember\Command as CreateCommand;
use App\Application\CrewMember\CreateCrewMember\CommandHandler;
use App\Application\Show\ShowFinderInterface;
use App\Domain\Show\ValueObject\ShowId;
use App\Framework\Form\CrewMemberType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CrewMemberController extends AbstractController
{
    #[Route('/crew-member/create/{showId}', 'crew-member.create', methods: ['GET', 'POST'])]
    public function create(Request $request, string $showId, CommandHandler $handler, ShowFinderInterface $finder): Response
    {
        $show = $finder->find(ShowId::fromString($showId));
        $command = CreateCommand::forShow($show);
        $form = $this->createForm(CrewMemberType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($command);

            return $this->redirectToRoute('show.show', ['id' => $show->id]);
        }

        return $this->render('./pages/crew-member/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/crew-member/{id}/update', 'crew-member.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id): Response
    {
        return $this->render('pages/crew-member/update.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }
}
