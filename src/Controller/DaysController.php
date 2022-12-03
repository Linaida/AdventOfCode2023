<?php

namespace App\Controller;

use App\EventDay1\MainService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DaysController extends AbstractController
{
    /**
     * @Route("/day1", name="app_day1", methods={"GET"})
     */
    public function day1(MainService $mainService, string $projectDir): JsonResponse
    {

        $fs = new Filesystem();
        $inputPath = Path::makeAbsolute( join(DIRECTORY_SEPARATOR,['public','files','day1input.txt']),$projectDir);
        if (!$fs->exists($inputPath)) {
           throw new FileNotFoundException(sprintf('Fichier inexistant [%s]', $inputPath));
        }
        $solution = $mainService->run($inputPath);

        return $this->json([
            'message' => sprintf('The solution of day 1 is [%s]', $solution),
            'path' => 'src/Controller/DaysController.php',
        ]);
    }


}
