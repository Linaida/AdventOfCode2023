<?php

namespace App\Elf;

use App\File\FileSplitter;

class InventoryService
{
    private FileSplitter $fileSplitter;

    public function __construct(FileSplitter $fileSplitter)
    {
        $this->fileSplitter = $fileSplitter;
    }

    public function getInventoriesFromPath(string $path): array
    {
        $inventories = $this->fileSplitter->splitBlankLine(file_get_contents($path));
        return $this->convertInventoriesToArray($inventories);
    }

    private function convertInventoriesToArray(array $inventories)
    {
        foreach ($inventories as $key => $value) {
            $inventories[$key] = $this->getInventoryFromStr($value);
        }
        return $inventories;
    }

    private function getInventoryFromStr(string $strInventory): array
    {
        return $this->fileSplitter->splitRNewLine($strInventory);
    }

    public function getSumCaloriesFromInventories(array $inventories)
    {
        $sumInventories = [];
        foreach ($inventories as $inventory) {
            $sumInventories []= array_sum($inventory);
        }
        arsort($sumInventories);
        return $sumInventories;
    }

    public function getTopThreeCalories(array $sumInventories)
    {
        reset($sumInventories);
        $firstElf = current($sumInventories);
        $secondElf = next($sumInventories);
        $thirdElf = next($sumInventories);
        return array_sum([$firstElf, $secondElf, $thirdElf]);
    }

}
