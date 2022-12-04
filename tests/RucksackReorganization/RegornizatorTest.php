<?php

namespace App\Tests\RucksackReorganization;

use App\RucksackReorganization\Reorganizator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RegornizatorTest extends KernelTestCase
{

    const RUCKSACK = 'vJrwpWtwJgWrhcsFMMfFFhFp';
    const LIST_RUCKSACK =
        <<<EOF
vJrwpWtwJgWrhcsFMMfFFhFp
jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL
PmmdzqPrVvPwwTWBwg
wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn
ttgJtRGJQctTZtZT
CrZsJsPPZsGzwwsLwLmpwMDw
EOF;
    public static $container;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        self::$container = static::getContainer();
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider inputProvider
     */
    public function testSplitRucksack(string $input, array $expected)
    {
        $regornizator =  self::$container->get(Reorganizator::class);
        $rucksacks = $regornizator->getRucksacks($input);
        $this->assertEquals($expected, $rucksacks);
    }

    /**
     * @param string $rucksack
     * @dataProvider rucksackProvider
     */
    public function testSplitCompartments(string $rucksack, array $expected)
    {
        $regornizator = self::$container->get(Reorganizator::class);
        $compartments = $regornizator->splitCompartments($rucksack);
        $this->assertEquals($expected, $compartments);

    }

    public function inputProvider()
    {
        return [
            [
                'vJrwpWtwJgWrhcsFMMfFFhFp
jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL
PmmdzqPrVvPwwTWBwg
wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn
ttgJtRGJQctTZtZT
CrZsJsPPZsGzwwsLwLmpwMDw', ['vJrwpWtwJgWrhcsFMMfFFhFp',
                'jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL',
                'PmmdzqPrVvPwwTWBwg',
                'wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn',
                'ttgJtRGJQctTZtZT',
                'CrZsJsPPZsGzwwsLwLmpwMDw']
            ]
        ];
    }

    public function rucksackProvider()
    {
        return [
            ['vJrwpWtwJgWrhcsFMMfFFhFp', ['vJrwpWtwJgWr', 'hcsFMMfFFhFp']],
            ['jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL', ['jqHRNqRjqzjGDLGL', 'rsFMfFZSrLrFZsSL']],
            ['PmmdzqPrVvPwwTWBwg', ['PmmdzqPrV', 'vPwwTWBwg']],
            ['wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn', ['wMqvLMZHhHMvwLH', 'jbvcjnnSBnvTQFn']],
            ['ttgJtRGJQctTZtZT', ['ttgJtRGJ', 'QctTZtZT']],
            ['CrZsJsPPZsGzwwsLwLmpwMDw', ['CrZsJsPPZsGz', 'wwsLwLmpwMDw']]
        ];
    }

}
