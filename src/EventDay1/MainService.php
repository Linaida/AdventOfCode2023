<?php

namespace App\EventDay1;

use App\Elf\InventoryService;

class MainService
{
    private InventoryService $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;

    }

    public function run(string $path)
    {
        $inventories = $this->inventoryService->getInventoriesFromPath($path);
        $sumInventories = $this->inventoryService->getSumCaloriesFromInventories($inventories);
        return $this->inventoryService->getTopThreeCalories($sumInventories);
    }
}