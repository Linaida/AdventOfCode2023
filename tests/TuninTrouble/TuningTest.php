<?php

namespace App\Tests\TuninTrouble;

use App\SupplyStacks\SupplyStacksService;
use App\TuningTrouble\TuningService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TuningTest extends KernelTestCase
{
    public static $container;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        self::$container = static::getContainer();
    }

    /**
     * @dataProvider datastreamProviders
     * @return void
     */
    public function testPart1(string $datastream, int $expected)
    {
        $tuningService = self::$container->get(TuningService::class);
        /**
         * @var TuningService $tuningService
         */
        $firstMarker = $tuningService->findSignal($datastream);
        $this->assertEquals($expected, $firstMarker);
    }

    /**
     * @dataProvider messagesstreamProviders
     * @return void
     */
    public function testPart2(string $datastream, int $expected)
    {
        $tuningService = self::$container->get(TuningService::class);
        /**
         * @var TuningService $tuningService
         */
        $firstMarker = $tuningService->findMessages($datastream);
        $this->assertEquals($expected, $firstMarker);
    }

    /**
     * @return array[]
     */
    public function datastreamProviders()
    {
        return [
            ['bvwbjplbgvbhsrlpgdmjqwftvncz',5],
            ['nppdvjthqldpwncqszvftbrmjlhg',6],
            ['nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg',10],
            ['zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw',11]
        ];
    }    /**
     * @return array[]
     */
    public function messagesstreamProviders()
    {
        return [
            ['mjqjpqmgbljsphdztnvjfqwrcgsmlb',19],
            ['bvwbjplbgvbhsrlpgdmjqwftvncz',23],
            ['nppdvjthqldpwncqszvftbrmjlhg',23],
            ['nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg',29],
            ['zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw',26]
        ];
    }
}
