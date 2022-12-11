<?php

namespace App\SupplyStacks\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Schema
{
    private array $stacks;
    private array $indexes;

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


}
