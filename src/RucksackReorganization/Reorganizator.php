<?php

namespace App\RucksackReorganization;

use App\File\FileSplitter;

class Reorganizator
{

    private FileSplitter $fileSplitter;
    private array $priorities;

    public function __construct(FileSplitter $fileSplitter)
    {
        $this->fileSplitter = $fileSplitter;
        $this->priorities = array_merge(['0'], range('a', 'z'), range('A', 'Z'));
    }

    public function run(string $content)
    {
        // 1 - On récupère tous les rucksack
        $rucksacks = $this->getRucksacks($content);
        $prioritiesTotal = 0;
        // 2 - Pour chaque rucksack :
        foreach ($rucksacks as $rucksack) {
            if (empty($rucksack)) {
                continue;
            }
            //   a - On split en 2 la chaine, et on met chaque moitié dans un tableau
            $compartmets = $this->splitCompartments($rucksack);
            //   b - On identifie la caractère unique commun au 2 motié
            $itemType = $this->getItemType($compartmets);
            //   c - On stocke cette valeur et on identifie sa priorité
            $prioritiesTotal += $this->getItemPriority($itemType);

        }
        // 3 - On fait le somme de toutes les priorités et on retourne le résultat
        return $prioritiesTotal;
    }


    public function runThreeGroup(string $content)
    {
        // 1 - On récupère les groupes et leur rucksack
        $groups = $this->getGroupsFromContent($content);
        $prioritiesTotal = 0;
        foreach ($groups as $group) {
            if (empty($group)) {
                continue;
            }
            // 2 - On récupère le badge de chaque groupe
            $itemType = $this->getItemType($group);
            //3 - On ajoute la priorité
            $prioritiesTotal += $this->getItemPriority($itemType);

        }
        // 3 - On fait le somme de toutes les priorités et on retourne le résultat
        return $prioritiesTotal;

    }

    public function splitCompartments(string $rucksack)
    {
        $nbChar = (strlen($rucksack) / 2);
        return str_split($rucksack, $nbChar);
    }

    public function getRucksacks(string $content)
    {
        return $this->fileSplitter->splitNewLine($content);
    }

    /**
     * Trouve la lettre commune au 2 compartiments
     * @param array $rucksacks
     * @return string
     */
    public function getItemType(array $rucksacks): string
    {
        try {
            $splitArray = [];

            foreach ($rucksacks as $rucksack) {
                $splitArray [] = str_split($rucksack);
            }
            $find = array_intersect($splitArray[0], $splitArray[1], $splitArray[2]);
            $find = array_unique($find);
            return current($find);
        } catch (\Error|\Exception $e) {
            echo $e->getMessage();
        }
        return '';
    }

    public function getItemPriority(string $itemType): int
    {
        return array_keys($this->priorities, $itemType, true)[0];
    }

    public function getGroupsFromContent(string $content): array
    {
        $rucksacks = $this->getRucksacks($content);
        $rucksacks = array_filter($rucksacks,function($item) {
            return (strlen($item > 0));
        });
        return array_chunk($rucksacks, 3);
    }

    private function getGroupBadge(array $group): string
    {
        return $this->getItemType($group);
    }
}
