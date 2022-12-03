<?php

namespace App\RockPaperScissors;

use App\File\FileSplitter;

class FileInputManager
{
    private FileSplitter $fileSplitter;

    public function __construct(FileSplitter $fileSplitter)
    {
        $this->fileSplitter = $fileSplitter;
    }

    public function getRounds(string $inputPath): array
    {
        $rounds = [];
        $fileContent = file_get_contents($inputPath);
        $strRounnds = $this->fileSplitter->splitNewLine($fileContent);
        foreach ($strRounnds as $strRound) {
            $hands = preg_split('/\s/',$strRound);
            if($hands[0] === '' || !isset($hands[1])){
                continue;
            }

            $op = new Opponent();
            $op->setHandShape($hands[0]);
            $player = new Player();
            $player->setHandShape($hands[1]);

            $round = new Round();
            $round->setOpponent($op)
            ->setPlayer($player);
            $rounds []= $round;
        }

        return $rounds;

    }
}
