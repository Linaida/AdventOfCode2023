<?php

namespace App\RucksackReorganization;

use App\File\FileSplitter;

class Reorganizator
{

    private FileSplitter $fileSplitter;

    public function __construct(FileSplitter $fileSplitter)
    {
        $this->fileSplitter = $fileSplitter;
    }

    public function run(string $content)
    {
        // 1 - On récupère tous les rucksack
        $rucksacks = $this->getRucksacks($content);
        // 2 - Pour chaque rucksack :
        foreach ($rucksacks as $rucksack) {
            //   a - On split en 2 la chaine, et on met chaque moitié dans un tableau
            $compartmets = $this->splitCompartments($rucksack);
            //   b - On identifie la caractère unique commun au 2 motié

        }
        //   c - On stocke cette valeur et on identifie sa priorité
        // 3 - On fait le somme de toutes les priorités et on retourne le résultat
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
     * @param string $firstItem
     * @param string $secondItem
     * @return string
     */
    public function getItemType(string $firstItem, string $secondItem): string
    {
        $ar1 = str_split($firstItem);
        $ar2 = str_split($secondItem);
        $find = array_intersect($ar1, $ar2);
        return current($find);
    }
}
