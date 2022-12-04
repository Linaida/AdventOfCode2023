<?php

namespace App\RockPaperScissors;

use App\File\FileSplitter;
use App\RockPaperScissors\Enum\HandShapeEnum;
use App\RockPaperScissors\Enum\RoundScoreEnum;

class RoundRunner
{


    private FileSplitter $fileSplitter;

    public function __construct(FileSplitter $fileSplitter)
    {
        $this->fileSplitter = $fileSplitter;
    }

    public function run(Round $round)
    {
        /** 1 => On récupère la main de l'opposant et celle du joueur*/
        $opponent = $round->getOpponent();
        $player = $round->getPlayer();
        return $this->calculatePlayerScore($opponent, $player);
    }

    public function runEndGame(Round $round)
    {
        /** 1 => On récupère la main de l'opposant et celle du joueur*/
        $opponent = $round->getOpponent();
        $player = $round->getPlayer();
        return $this->calculateEndScore($opponent, $player);
    }


    /**
     * @param string $inputPath
     * @return array
     */
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

    public function calculatePlayerScore(Opponent $oppenent, Player $player)
    {
        /**
         * On récupére le calcul de la main
         */

        $opHand = $oppenent->getHandShape();
        $playerHand = $player->getHandShape();
        $playerHandScore = HandShapeEnum::getPoints($playerHand);
        $playerScore = $playerHandScore + $this->roundCalculator($opHand, $playerHand);
        $player->setScore($playerScore);

        /**
         * On récupère le calcul du round
         */
        return $player->getScore();


    }

    /**
     * @throws \ErrorException
     */
    public function calculateEndScore(Opponent $oppenent, Player $player)
    {
        /**
         * On récupére le calcul de la main
         */

        $opHand = $oppenent->getHandShape();
        $playerHand = $player->getHandShape();
        $playerScore =  $this->roundEndCalculator($opHand, $playerHand);
        $player->setScore($playerScore);

        /**
         * On récupère le calcul du round
         */
        return $player->getScore();


    }

    public function roundCalculator(string $opponentHand, string $playerHand)
    {
        if ( HandShapeEnum::getPoints($opponentHand) ===  HandShapeEnum::getPoints($playerHand)) {
            return RoundScoreEnum::DRAW;
        }

        switch ($opponentHand) {
            case HandShapeEnum::ROCK: {
                if($playerHand === HandShapeEnum::PAPER_PLAYER) {
                    return RoundScoreEnum::WON;
                }
                break;
            }
            case HandShapeEnum::PAPER: {
                if($playerHand === HandShapeEnum::SCISSORS_PLAYER) {
                    return RoundScoreEnum::WON;
                }
                break;
            }
            case HandShapeEnum::SCISSORS: {
                if($playerHand === HandShapeEnum::ROCK_PLAYER) {
                    return RoundScoreEnum::WON;
                }
                break;
            }
        }

        return RoundScoreEnum::LOST;

    }

    public function roundEndCalculator(string $opponentHand, string $playerHand): int
    {
        switch ($playerHand) {
            case RoundScoreEnum::DRAW_PLAYER:
                return $this->draw($opponentHand);
            case RoundScoreEnum::LOST_PLAYER:
                return $this->loose($opponentHand);
            case RoundScoreEnum::WON_PLAYER:
                return $this->won($opponentHand);
            default:
                throw new \ErrorException('Aucune main n\'a été trouvée.');
        }

    }

    private function draw(string $opponentHand)
    {
        return RoundScoreEnum::DRAW + HandShapeEnum::getPoints($opponentHand);
    }

    private function won(string $opponentHand)
    {
        switch ($opponentHand) {
            case HandShapeEnum::ROCK: {
                $hand = HandShapeEnum::PAPER;
                break;
            }
            case HandShapeEnum::PAPER: {
                $hand = HandShapeEnum::SCISSORS;
                break;
            }
            case HandShapeEnum::SCISSORS: {
                $hand = HandShapeEnum::ROCK;
                break;
            }
        }

        return RoundScoreEnum::WON + HandShapeEnum::getPoints($hand);
    }

    private function loose(string $opponentHand)
    {
        switch ($opponentHand) {
            case HandShapeEnum::ROCK: {
                $hand = HandShapeEnum::SCISSORS;
                break;
            }
            case HandShapeEnum::PAPER: {
                $hand = HandShapeEnum::ROCK;
                break;
            }
            case HandShapeEnum::SCISSORS: {
                $hand = HandShapeEnum::PAPER;
                break;
            }
        }

        return RoundScoreEnum::LOST + HandShapeEnum::getPoints($hand);
    }

}
