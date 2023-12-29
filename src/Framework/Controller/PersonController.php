<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\Person\CreatePerson\Command as CreateCommand;
use App\Application\Person\CreatePerson\CommandHandler as CreateCommandHandler;
use App\Application\Person\PersonFinderInterface;
use App\Framework\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PersonController extends AbstractController
{
    #[Route('/person', 'person.index', methods: ['GET'])]
    public function index(PersonFinderInterface $finder): Response
    {
        $people = [];
        return $this->render(
            'pages/person/index.html.twig',
            [
                'people' => $people
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
}
