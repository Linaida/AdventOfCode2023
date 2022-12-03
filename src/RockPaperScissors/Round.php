<?php

namespace App\RockPaperScissors;

class Round
{
    private Opponent $opponent;
    private Player $player;
    private int $score = 0;


    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return Opponent
     */
    public function getOpponent(): Opponent
    {
        return $this->opponent;
    }

    /**
     * @param Opponent $opponent
     */
    public function setOpponent(Opponent $opponent): Round
    {
        $this->opponent = $opponent;
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer(Player $player): Round
    {
        $this->player = $player;
        return $this;
    }


}
