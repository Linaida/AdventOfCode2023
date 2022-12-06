<?php

namespace App\CampCleanup;

class Pair
{
    private Section $firstElf;
    private Section $secondElf;

    /**
     * @return Section
     */
    public function getFirstElf(): Section
    {
        return $this->firstElf;
    }

    /**
     * @param Section $firstElf
     * @return Pair
     */
    public function setFirstElf(Section $firstElf): Pair
    {
        $this->firstElf = $firstElf;
        return $this;
    }

    /**
     * @return Section
     */
    public function getSecondElf(): Section
    {
        return $this->secondElf;
    }

    /**
     * @param Section $secondElf
     * @return Pair
     */
    public function setSecondElf(Section $secondElf): Pair
    {
        $this->secondElf = $secondElf;
        return $this;
    }


}
