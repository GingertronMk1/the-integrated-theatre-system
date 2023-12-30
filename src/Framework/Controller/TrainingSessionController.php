<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Framework\Form\TrainingSessionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TrainingSessionController extends AbstractController
{
    #[Route('training-session/create', 'training-session.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        // $command = new CreateCommand();
        $form = $this->createForm(TrainingSessionType::class);
        $form->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid()) {
        //     try {
        //         $handler->handle($command);
        //         $this->addFlash('success', 'Created training Session');

        //         $returnRoute = $request->get('return_to', 'training-session.index');

        //         return $this->redirectToRoute($returnRoute);
        //     } catch (Exception $e) {
        //         throw $e;
        //     }
        // }

        return $this->render('pages/training-session/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
