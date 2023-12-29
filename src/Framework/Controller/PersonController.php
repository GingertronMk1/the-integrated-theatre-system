<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\Person\PersonFinderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
