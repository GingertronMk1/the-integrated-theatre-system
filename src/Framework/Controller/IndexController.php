<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Application\Person\PersonFinderInterface;
use App\Application\Season\SeasonFinderInterface;
use App\Application\Show\ShowFinderInterface;
use App\Application\TrainingCategory\TrainingCategoryFinderInterface;
use App\Application\TrainingItem\TrainingItemFinderInterface;
use App\Application\TrainingSession\TrainingSessionFinderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        ShowFinderInterface $showFinder,
        SeasonFinderInterface $seasonFinder,
        PersonFinderInterface $personFinder,
        TrainingCategoryFinderInterface $trainingCategoryFinder,
        TrainingItemFinderInterface $trainingItemFinder,
        TrainingSessionFinderInterface $trainingSessionFinder
    ): Response {
        return $this->render(
            'pages/index/index.html.twig',
            [
                'shows' => $showFinder->count(),
                'seasons' => $seasonFinder->count(),
                'people' => $personFinder->count(),
                'trainingCategories' => $trainingCategoryFinder->count(),
                'trainingItems' => $trainingItemFinder->count(),
                'trainingSessions' => $trainingSessionFinder->count(),
            ]
        );
    }
}
