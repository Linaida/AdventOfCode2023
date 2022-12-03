<?php

namespace App\RockPaperScissors;

class Player
{
    private string $handShape;
    private int $score = 0;

    /**
     * @return string
     */
    public function getHandShape(): string
    {
        return $this->handShape;
    }

    /**
     * @param string $handShape
     * @return Player
     */
    public function setHandShape(string $handShape): Player
    {
        $this->handShape = $handShape;
        return $this;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     * @return Player
     */
    public function setScore(int $score): Player
    {
        $this->score = $score;
        return $this;
    }


}
