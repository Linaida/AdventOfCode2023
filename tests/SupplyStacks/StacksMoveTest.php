<?php

namespace App\Tests\SupplyStacks;

use App\SupplyStacks\SupplyStacksService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StacksMoveTest extends KernelTestCase
{
    public static $container;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        self::$container = static::getContainer();
    }

    public function testRun()
    {
        $projectDir = self::$container->getParameter('kernel.project_dir');
        $filename = join(DIRECTORY_SEPARATOR,[__DIR__,'stacks.txt']);
        $supplyStacksService = self::$container->get(SupplyStacksService::class);
        /**
         * @var SupplyStacksService $supplyStacksService
         */
        $stacks = $supplyStacksService->runPart1(file_get_contents($filename));

        $this->assertNotEmpty($stacks);
    }
}
