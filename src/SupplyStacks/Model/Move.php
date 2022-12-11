<?php

namespace App\SupplyStacks\Model;

class Move
{
    private int $numbers;
    private int $from;
    private int $to;

    /**
     * @return int
     */
    public function getNumbers(): int
    {
        return $this->numbers;
    }

    /**
     * @param int $numbers
     * @return Move
     */
    public function setNumbers(int $numbers): Move
    {
        $this->numbers = $numbers;
        return $this;
    }

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @param int $from
     * @return Move
     */
    public function setFrom(int $from): Move
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
    }

    /**
     * @param int $to
     * @return Move
     */
    public function setTo(int $to): Move
    {
        $this->to = $to;
        return $this;
    }


}
