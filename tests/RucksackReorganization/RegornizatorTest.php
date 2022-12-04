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
        $regornizator = self::$container->get(Reorganizator::class);
        $rucksacks = $regornizator->getRucksacks($input);
        $this->assertEquals($expected, $rucksacks);
        return $rucksacks;
    }

    /**
     * @param string $rucksack
     * @param array $expected
     * @return mixed
     * @dataProvider rucksackProvider
     */
    public function testSplitCompartments(string $rucksack, array $expected)
    {
        $regornizator = self::$container->get(Reorganizator::class);
        $compartments = $regornizator->splitCompartments($rucksack);
        $this->assertEquals($expected, $compartments);
        return $compartments;

    }

    /**
     * @param array $compartments
     * @param string $expected
     * @return void
     *
     * @dataProvider compartmentsProvider
     */
    public function testGetItemType(array $compartments, string $expected)
    {
        $regornizator = self::$container->get(Reorganizator::class);
        $itemType = $regornizator->getItemType($compartments[0], $compartments[1]);
        $this->assertEquals($expected, $itemType);

    }

    /**
     * @param string $item
     * @param int $expected
     * @return void
     *
     * @dataProvider itemTypeProvider
     */
    public function testGetItemPriority(string $item, int $expected)
    {
        $regornizator = self::$container->get(Reorganizator::class);
        $priority = $regornizator->getItemPriority($item);
        $this->assertEquals($expected, $priority);


    }

    /**
     * @param string $content
     * @param array $expected
     * @return void
     * @dataProvider inputGroupsProvider
     */
    public function testGetGroups(string $content, array $expected)
    {
        $regornizator = self::$container->get(Reorganizator::class);
        $groups = $regornizator->getGroupsFromContent($content);
        $this->assertEquals($expected, $groups);

    }

    /**
     * @param array $group
     * @param string $expected
     * @return void
     * @dataProvider inputGroupProvider
     */
    public function testGetGroupBadge(array $group, string $expected)
    {
        $regornizator = self::$container->get(Reorganizator::class);
        $badge = $regornizator->getItemType($group);
        $this->assertEquals($expected, $badge);
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

    public function compartmentsProvider()
    {
        return [
            [['vJrwpWtwJgWr', 'hcsFMMfFFhFp'], 'p'],
            [['jqHRNqRjqzjGDLGL', 'rsFMfFZSrLrFZsSL'], 'L'],
            [['PmmdzqPrV', 'vPwwTWBwg'], 'P'],
            [['wMqvLMZHhHMvwLH', 'jbvcjnnSBnvTQFn'], 'v'],
            [['ttgJtRGJ', 'QctTZtZT'], 't'],
            [['CrZsJsPPZsGz', 'wwsLwLmpwMDw'], 's']
        ];
    }

    public function itemTypeProvider()
    {
        return [
            ['a', 1],
            ['z', 26],
            ['A', 27],
            ['Z', 52]
        ];
    }

    public function inputGroupsProvider()
    {
        return [
            [
                'vJrwpWtwJgWrhcsFMMfFFhFp
jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL
PmmdzqPrVvPwwTWBwg
wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn
ttgJtRGJQctTZtZT
CrZsJsPPZsGzwwsLwLmpwMDw', [
                ['vJrwpWtwJgWrhcsFMMfFFhFp', 'jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL', 'PmmdzqPrVvPwwTWBwg'],
                ['wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn', 'ttgJtRGJQctTZtZT', 'CrZsJsPPZsGzwwsLwLmpwMDw']
            ]
            ]
        ];
    }

    public function inputGroupProvider()
    {
        return [
            [
                ['vJrwpWtwJgWrhcsFMMfFFhFp', 'jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL', 'PmmdzqPrVvPwwTWBwg'], 'r'
            ],
            [
                ['wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn', 'ttgJtRGJQctTZtZT', 'CrZsJsPPZsGzwwsLwLmpwMDw'], 'Z'
            ]

        ];
    }

}
