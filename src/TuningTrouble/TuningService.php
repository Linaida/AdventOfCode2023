<?php

namespace App\TuningTrouble;

use Doctrine\Common\Collections\ArrayCollection;

class TuningService
{
    public function findSignal(string $content, int $sizeSlice = 4): int
    {
        $markers = [];

        $stream = str_split($content);
        $offset = 1;
        do {
            $slice = array_slice($stream, $offset, $sizeSlice, true);
            $markers = array_unique($slice);
            $offset++;

        } while (sizeof($markers) < $sizeSlice);


        return array_key_last($markers) + 1;
    }

    public function findMessages(string $content)
    {
        return $this->findSignal($content, 14);
    }

    public function run(string $content)
    {
        return ['part1' => $this->findSignal($content), 'part2' => $this->findMessages($content)];

    }
}
