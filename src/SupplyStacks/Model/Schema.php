<?php

namespace App\SupplyStacks\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Schema
{
    private array $stacks;
    private array $linesStacks;
    private array $indexes;

    private array $moves;

    /**
     * @return array
     */
    public function getStacks(): array
    {
        return $this->stacks;
    }

    /**
     * @param array $stacks
     * @return Schema
     */
    public function setStacks(array $stacks): Schema
    {
        $this->stacks = $stacks;
        return $this;
    }

    /**
     * @return array
     */
    public function getIndexes(): array
    {
        return $this->indexes;
    }

    /**
     * @param array $indexes
     * @return Schema
     */
    public function setIndexes(array $indexes): Schema
    {
        $this->indexes = $indexes;
        return $this;
    }

    /**
     * @return array
     */
    public function getMoves(): array
    {
        return $this->moves;
    }

    /**
     * @param array $moves
     * @return Schema
     */
    public function setMoves(array $moves): Schema
    {
        $this->moves = $moves;
        return $this;
    }

    /**
     * @return array
     */
    public function getLinesStacks(): array
    {
        return $this->linesStacks;
    }

    /**
     * @param array $linesStacks
     * @return Schema
     */
    public function setLinesStacks(array $linesStacks): Schema
    {
        $this->linesStacks = $linesStacks;
        return $this;
    }


}
