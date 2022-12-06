<?php

namespace App\CampCleanup;

use App\File\FileSplitter;

class AssignmentService
{


    private FileSplitter $fileSplitter;

    public function __construct(FileSplitter $fileSplitter)
    {
        $this->fileSplitter = $fileSplitter;
    }

    public function getPairsWithFullyContains(string $inputContent): int
    {
        $assignements = $this->getAssignments($inputContent);
        $pairs = $this->getPairs($assignements);
        $onlyContained = $this->getOnlyFullyContained($pairs);
        return count($onlyContained);

    }

    public function getPairsOverlapping(string $inputContent): int
    {
        $assignements = $this->getAssignments($inputContent);
        $pairs = $this->getPairs($assignements);
        $onlyOverlapping = $this->extractOverlappingPairs($pairs);
        return count($onlyOverlapping);
    }

    public function getAssignments(string $inputContent)
    {
        $assigments = $this->fileSplitter->splitNewLine($inputContent);
        return array_map('trim', $assigments);
    }

    public function getPairs(array $assignements): array {
        $pairs = [];
        foreach ($assignements as $assignement) {
            if($assignement ==='') {
                continue;
            }
            $parts = preg_split('/[-,]/', $assignement);

            $firstSection = new Section();
            $firstSection->setStart((int)$parts[0])
                    ->setEnd((int)$parts[1]);

            $secondSection = new Section();
            $secondSection->setStart((int)$parts[2])
                    ->setEnd((int)$parts[3]);

            $pair = new Pair();
            $pair->setFirstElf($firstSection);
            $pair->setSecondElf($secondSection);

            $pairs []= $pair;

        }

        return $pairs;
    }

    function getOnlyFullyContained(array $pairs): array {
        return array_filter($pairs, function (Pair $pair){
            $first = $pair->getFirstElf();
            $second = $pair->getSecondElf();
            return  $first->has($second) || $second->has($first);
        });
    }

    public function extractOverlappingPairs(array $pairs): array
    {
        return array_filter($pairs, function (Pair $pair){
            $first = $pair->getFirstElf();
            $second = $pair->getSecondElf();
            return  $first->isOverlappedBy($second) || $second->isOverlappedBy($first);
        });
    }

}
