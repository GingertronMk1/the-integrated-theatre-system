<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\CrewRole\CreateCrewRole\Command as CreateCommand;
use App\Application\CrewRole\CreateCrewRole\CommandHandler as CreateCommandHandler;
use App\Application\CrewRole\CrewRoleFinderInterface;
use App\Application\CrewRole\UpdateCrewRole\Command as UpdateCommand;
use App\Application\CrewRole\UpdateCrewRole\CommandHandler as UpdateCommandHandler;
use App\Domain\CrewRole\ValueObject\CrewRoleId;
use App\Framework\Form\CrewRoleType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CrewRoleController extends AbstractController
{
    #[Route('/crew-role', 'crew-role.index', methods: ['GET'])]
    public function index(CrewRoleFinderInterface $finder): Response
    {
        $crewRoles = $finder->findAll();

        return $this->render(
            'pages/crew-role/index.html.twig',
            [
                'crew_roles' => $crewRoles,
            ]
        );
    }

    #[Route('/crew-role/create', 'crew-role.create', methods: ['GET', 'POST'])]
    public function create(Request $request, CreateCommandHandler $handler): Response
    {
        $command = new CreateCommand();
        $form = $this->createForm(CrewRoleType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Created training item');

                $returnRoute = $request->get('return_to', 'crew-role.index');

                return $this->redirectToRoute($returnRoute);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $this->render('pages/crew-role/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/crew-role/{id}/update', 'crew-role.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id, UpdateCommandHandler $handler, CrewRoleFinderInterface $finder): Response
    {
        $item = $finder->find(CrewRoleId::fromString($id));
        $command = UpdateCommand::forCrewRole($item);
        $form = $this->createForm(CrewRoleType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Updated crew role');

                $returnRoute = $request->get('return_to', 'crew-role.index');

                return $this->redirectToRoute($returnRoute);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $this->render('pages/crew-role/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
