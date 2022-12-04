<?php

namespace App\Controller;

use App\Elf\InventoryService;
use App\RockPaperScissors\FileInputManager;
use App\RockPaperScissors\RoundRunner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DaysController extends AbstractController
{
    private FileInputManager $fileInputManager;

    public function __construct(FileInputManager $fileInputManager)
    {
        $this->fileInputManager = $fileInputManager;
    }


    /**
     * @Route("/day1", name="app_day1", methods={"GET"})
     */
    public function day1(InventoryService $inventoryService): JsonResponse
    {
        $inputPath =  $this->fileInputManager->getInputPath(1);
        $solution = $inventoryService->run($inputPath);

        return $this->json([
            'message' => sprintf('The solution of day 1 is [%s]', $solution),
            'path' => 'src/Controller/DaysController.php',
        ]);
    }


    /**
     * @Route("/day2", name="app_day2", methods={"GET"})
     */
    public function day2(RoundRunner $roundRunner)
    {
        $inputPath =  $this->fileInputManager->getInputPath(2);
        $rounds = $roundRunner->getRounds($inputPath);
        $totalScore = 0;
        foreach ($rounds as $round) {
            $totalScore += $roundRunner->run($round);
        }

        return $this->json([
            'message' => sprintf('The solution of day 2 is [%s]', $totalScore)
        ]);

    }
    /**
     * @Route("/day2/part2", name="app_day2_part2", methods={"GET"})
     */
    public function day2part2(FileInputManager $fileInputManager, RoundRunner $roundRunner)
    {
        $inputPath =  $this->fileInputManager->getInputPath(2);
        $rounds = $roundRunner->getRounds($inputPath);
        $totalScore = 0;
        foreach ($rounds as $round) {
            $totalScore += $roundRunner->runEndGame($round);
        }

        return $this->json([
            'message' => sprintf('The solution of day 2 is [%s]', $totalScore)
        ]);

    }

    public function day3part1()
    {
        $inputPath =  $this->fileInputManager->getInputPath(3);

    }

}
