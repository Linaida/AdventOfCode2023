<?php

namespace App\SupplyStacks\Model;

class Crate
{
    private string $value;

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Crate
     */
    public function setValue(string $value): Crate
    {
        $this->value = $value;
        return $this;
    }

    public function getLetter()
    {
        return str_replace(['[',']'],'',$this->getValue());
    }



}
