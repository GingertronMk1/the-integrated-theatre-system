<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\Person\CreatePerson\Command as CreateCommand;
use App\Application\Person\CreatePerson\CommandHandler as CreateCommandHandler;
use App\Application\Person\PersonFinderInterface;
use App\Application\Person\UpdatePerson\Command;
use App\Application\Person\UpdatePerson\CommandHandler;
use App\Domain\Person\ValueObject\PersonId;
use App\Framework\Form\PersonType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PersonController extends AbstractController
{
    #[Route('/person', 'person.index', methods: ['GET'])]
    public function index(PersonFinderInterface $finder): Response
    {
        $people = $finder->findAll();

        return $this->render(
            'pages/person/index.html.twig',
            [
                'people' => $people,
            ]
        );
    }

    #[Route('/person/create', 'person.create', methods: ['GET', 'POST'])]
    public function create(Request $request, CreateCommandHandler $handler): Response
    {
        $command = new CreateCommand();
        $form = $this->createForm(PersonType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Created training item');

                $returnRoute = $request->get('return_to', 'person.index');

                return $this->redirectToRoute($returnRoute);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $this->render('pages/person/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/person/{id}/update', 'person.update', methods: ['GET', 'POST'])]
    public function update(Request $request, string $id, CommandHandler $handler, PersonFinderInterface $finder): Response
    {
        $item = $finder->find(PersonId::fromString($id));
        $command = Command::forPerson($item);
        $form = $this->createForm(PersonType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Updated person');

                $returnRoute = $request->get('return_to', 'person.index');

                return $this->redirectToRoute($returnRoute);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $this->render('pages/person/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
