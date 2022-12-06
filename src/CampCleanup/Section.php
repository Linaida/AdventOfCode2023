<?php

namespace App\CampCleanup;

class Section
{
    private int $start;
    private int $end;

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @param int $start
     * @return Section
     */
    public function setStart(int $start): Section
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return int
     */
    public function getEnd(): int
    {
        return $this->end;
    }

    /**
     * @param int $end
     * @return Section
     */
    public function setEnd(int $end): Section
    {
        $this->end = $end;
        return $this;
    }

    public function has(Section $other)
    {
        return $this->start <= $other->getStart() && $this->end >= $other->getEnd();
    }

    public function isOverlappedBy(Section $other)
    {
        return ($this->start <= $other->getEnd() && $this->end >= $other->getEnd());
    }


}
