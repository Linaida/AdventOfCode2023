<?php

namespace App\RockPaperScissors;

use App\RockPaperScissors\Enum\HandShapeEnum;
use App\RockPaperScissors\Enum\RoundScoreEnum;

class RoundRunner
{

    public function run(Round $round)
    {
        /** 1 => On récupère la main de l'opposant et celle du joueur*/
        $opponent = $round->getOpponent();
        $player = $round->getPlayer();
        return $this->calculatePlayerScore($opponent, $player);
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



}
