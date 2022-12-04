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

    public function run(string $inputPath)
    {
        // 1 - On récupère tous les rucksack
        // 2 - Pour chaque rucksack :
        //   a - On split en 2 la chaine, et on met chaque moitié dans un tableau
        //   b - On identifie la caractère unique commun au 2 motié
        //   c - On stocke cette valeur et on identifie sa priorité
        // 3 - On fait le somme de toutes les priorités et on retourne le résultat
    }

    public function splitCompartments(string $rucksack)
    {
        $nbChar = (strlen($rucksack) / 2);
        return str_split($rucksack, $nbChar);
    }

    public function getRucksacks(string $input)
    {
        return $this->fileSplitter->splitNewLine($input);

    }
}
