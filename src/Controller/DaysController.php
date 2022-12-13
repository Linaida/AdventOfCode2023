<?php

namespace App\Controller;

use App\CampCleanup\AssignmentService;
use App\Elf\InventoryService;
use App\RockPaperScissors\FileInputManager;
use App\RockPaperScissors\RoundRunner;
use App\RucksackReorganization\Reorganizator;
use App\SupplyStacks\SupplyStacksService;
use App\TuningTrouble\TuningService;
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

    /**
     * @Route("/day3/part1", name="app_day3_part1", methods={"GET"})
     */
    public function day3part1(Reorganizator $reorganizator)
    {
        $content =  $this->fileInputManager->getInputContent(3);
        $total = $reorganizator->run($content);
        return $this->json([
            'message' => sprintf('The solution of day 3 part 1 is [%s]', $total)
        ]);
    }

    /**
     * @Route("/day3/part2", name="app_day3_part2", methods={"GET"})
     */
    public function day3part2(Reorganizator $reorganizator)
    {
        $content =  $this->fileInputManager->getInputContent(3);
        $total = $reorganizator->runThreeGroup($content);
        return $this->json([
            'message' => sprintf('The solution of day 3 part 2 is [%s]', $total)
        ]);
    }
    /**
     * @Route("/day4", name="app_day4", methods={"GET"})
     */
    public function day4(AssignmentService $assignmentService)
    {
        $content =  $this->fileInputManager->getInputContent(4);
        $totalFullyContainedPairs = $assignmentService->getPairsWithFullyContains($content);
        $totalOverlappedPairs = $assignmentService->getPairsOverlapping($content);
        return $this->json([
            'message' => sprintf('Day 4: There is [%s] pairs fully contained ans [%s] overlapped', $totalFullyContainedPairs, $totalOverlappedPairs)
        ]);
    }

    /**
     * @Route("/day5", name="app_day5", methods={"GET"})
     */
    public function day5(SupplyStacksService $supplyStacksService)
    {
        $content =  $this->fileInputManager->getInputContent(5);
        $parts= $supplyStacksService->run($content);
        return $this->json([
            'message' => sprintf('Day 5: Part1 [%s] - Part2 [%s] ', $parts['part1'], $parts['part2'])
        ]);
    }
    /**
     * @Route("/day6", name="app_day6", methods={"GET"})
     */
    public function day6(TuningService $tuningService)
    {
        $content =  $this->fileInputManager->getInputContent(6);
        $parts= $tuningService->run($content);
        return $this->json([
            'message' => sprintf('Day 5: Part1 [%s] - Part2 [%s] ', $parts['part1'], $parts['part2'])
        ]);
    }
}
