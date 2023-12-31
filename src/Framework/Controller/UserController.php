<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\User\CreateUser\Command;
use App\Application\User\CreateUser\CommandHandler;
use App\Framework\Form\UserType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user/create', 'user.create', methods: ['GET', 'POST'])]
    public function create(Request $request, CommandHandler $handler): Response
    {
        $command = new Command();
        $form = $this->createForm(UserType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Created user');

                $returnRoute = $request->get('return_to', 'index');

                return $this->redirectToRoute($returnRoute);
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $this->render('pages/user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
