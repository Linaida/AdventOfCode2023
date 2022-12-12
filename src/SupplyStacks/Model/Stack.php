<?php

namespace App\SupplyStacks\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Stack
{
    private ArrayCollection $crates;
    private int $id;

    public function __construct()
    {
        $this->crates = new ArrayCollection();
    }

    public function addCrate(Crate $crate)
    {
        $this->crates->add($crate);
    }

    public function removeCrate(Crate $crate)
    {
        if ($this->crates->contains($crate)) {
            $this->crates->removeElement($crate);
        }
    }

    public function getTopCrate()
    {
        return $this->crates->last();
    }

    public function getTopCrates(int $number)
    {
        $slice = [];
        $crates = $this->crates->toArray();
        if($number > sizeof($crates)){
            throw new \Exception(sprintf("La taille demandée [%s] est supérieur à celle du stack [%s]",$number, sizeof($crates)));
        }
        while ($number > 0) {
            $current = array_pop($crates);
            if ($current instanceof Crate) {
                $slice []= $current;
            }
            $number--;
        }
        return array_reverse($slice);



    }

    public function getCratesFromArray(array $cratesValues): static
    {
        $this->crates = new ArrayCollection();
        for ($i = count($cratesValues); $i > 0; $i--) {
            $current = $cratesValues[$i - 1];
            if (preg_match('/\[[A-Z]\]/', $current)) {
                $crate = new Crate();
                $crate->setValue($current);
                $this->addCrate($crate);

            }
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Stack
     */
    public function setId(int $id): Stack
    {
        $this->id = $id;
        return $this;
    }

    public function isEmpty(): bool
    {
        return $this->crates->isEmpty();
    }


}
