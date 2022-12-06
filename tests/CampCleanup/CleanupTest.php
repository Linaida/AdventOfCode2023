<?php

namespace App\Tests\CampCleanup;

use App\CampCleanup\AssignmentService;
use App\CampCleanup\Pair;
use App\CampCleanup\Section;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CleanupTest extends KernelTestCase
{
    public static $container;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        self::$container = static::getContainer();
    }

    /**
     * @dataProvider assignmentsProvider
     * @param string $content
     * @param array $expected
     */
    public function testGetAssignements(string $content, array $expected)
    {
        $assignementService = self::$container->get(AssignmentService::class);
        $assignements = $assignementService->getAssignments($content);
        $this->assertEquals($expected, $assignements);

    }

    /**
     * @dataProvider pairsProvider
     * @param array $assignements
     * @param array $expected
     */
    public function testGetPairs(array $assignements, array $expected)
    {
        $assignementService = self::$container->get(AssignmentService::class);
        /**
         * @var AssignmentService $assignementService
         */
        $pairs = $assignementService->getPairs($assignements);
        $this->assertEquals($expected, $pairs);
    }


    /**
     */
    public function testFullyContainedSections()
    {
        $assignementService = self::$container->get(AssignmentService::class);
        /**
         * @var AssignmentService $assignementService
         */
        $pairs = $assignementService->getPairs(['2-4,6-8','2-3,4-5','5-7,7-9','2-8,3-7','6-6,4-6','2-6,4-8']);
        $contained = $assignementService->getOnlyFullyContained($pairs);
        $this->assertCount(2, $contained);
    }

    public function testOverlappedSections()
    {
        $assignementService = self::$container->get(AssignmentService::class);
        /**
         * @var AssignmentService $assignementService
         */
        $content = '2-4,6-8
                    2-3,4-5
                    5-7,7-9
                    2-8,3-7
                    6-6,4-6
                    2-6,4-8';
        $contained = $assignementService->getPairsOverlapping($content);
        $this->assertEquals(4, $contained);
    }


    public function assignmentsProvider()
    {
        return [
            ['2-4,6-8
             2-3,4-5
             5-7,7-9
             2-8,3-7
             6-6,4-6
             2-6,4-8',['2-4,6-8','2-3,4-5','5-7,7-9','2-8,3-7','6-6,4-6','2-6,4-8']
            ]
        ];
    }

    public function pairsProvider()
    {
        $firstPair = new Pair();
        $firstElf = new Section();
        $firstElf->setStart(2);
        $firstElf->setEnd(4);
        $firstPair->setFirstElf($firstElf);

        $secondElf = new Section();
        $secondElf->setStart(6);
        $secondElf->setEnd(8);
        $firstPair->setSecondElf($secondElf);

        $secondPair = new Pair();
        $firstElf = new Section();
        $firstElf->setStart(2);
        $firstElf->setEnd(3);
        $secondPair->setFirstElf($firstElf);

        $secondElf = new Section();
        $secondElf->setStart(4);
        $secondElf->setEnd(5);
        $secondPair->setSecondElf($secondElf);


        return [
            [
                ['2-4,6-8','2-3,4-5'],[$firstPair,$secondPair]
            ]
        ];

    }

}
