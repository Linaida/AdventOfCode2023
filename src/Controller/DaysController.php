<?php

namespace App\Controller;

use App\EventDay1\MainService;
use App\File\EventInputReader;
use App\RockPaperScissors\FileInputManager;
use App\RockPaperScissors\RoundRunner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DaysController extends AbstractController
{
    private EventInputReader $eventInputReader;

    public function __construct(EventInputReader $eventInputReader)
    {
        $this->eventInputReader = $eventInputReader;
    }


    /**
     * @Route("/day1", name="app_day1", methods={"GET"})
     */
    public function day1(MainService $mainService): JsonResponse
    {
        $inputPath =  $this->eventInputReader->getInputPath(1);
        $solution = $mainService->run($inputPath);

        return $this->json([
            'message' => sprintf('The solution of day 1 is [%s]', $solution),
            'path' => 'src/Controller/DaysController.php',
        ]);
    }


    /**
     * @Route("/day2", name="app_day2", methods={"GET"})
     */
    public function day2(FileInputManager $fileInputManager, RoundRunner $roundRunner)
    {
        $inputPath =  $this->eventInputReader->getInputPath(2);
        $rounds = $fileInputManager->getRounds($inputPath);
        $totalScore = 0;
        foreach ($rounds as $round) {
            $totalScore += $roundRunner->run($round);
        }

        return $this->json([
            'message' => sprintf('The solution of day 2 is [%s]', $totalScore)
        ]);

    }

}
