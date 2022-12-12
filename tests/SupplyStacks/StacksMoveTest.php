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

    public function testPart1()
    {
        $filename = join(DIRECTORY_SEPARATOR,[__DIR__,'stacks.txt']);
        $supplyStacksService = self::$container->get(SupplyStacksService::class);
        /**
         * @var SupplyStacksService $supplyStacksService
         */
        $content = file_get_contents($filename);
        $schema = $supplyStacksService->getSchemaFromContent($content);
        $part1 = $supplyStacksService->runPart1($schema);
        $this->assertNotEmpty($part1);
    }

    public function testPart2()
    {
        $filename = join(DIRECTORY_SEPARATOR,[__DIR__,'stacks.txt']);
        $supplyStacksService = self::$container->get(SupplyStacksService::class);
        /**
         * @var SupplyStacksService $supplyStacksService
         */
        $content = file_get_contents($filename);
        $schema = $supplyStacksService->getSchemaFromContent($content);
        $part2 = $supplyStacksService->runPart2($schema);
        $this->assertEquals('MCD',$part2);
    }
}
