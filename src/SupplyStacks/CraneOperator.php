<?php

namespace App\SupplyStacks;

use App\SupplyStacks\Model\Move;
use App\SupplyStacks\Model\Stack;
use Psr\Log\LoggerInterface;

class CraneOperator
{
    const CRANE_OPERATOR_9000 = 0;
    const CRANE_OPERATOR_9001 = 1;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

    }

    public function move(Stack $stackFrom, Stack $stackTo, int $numbers, int $craneOperator)
    {
        switch ($craneOperator) {
            case self::CRANE_OPERATOR_9000:
                $this->moveCrates9000($stackFrom, $stackTo, $numbers);
                return 0;
            case self::CRANE_OPERATOR_9001:
                $this->moveCrates9001($stackFrom, $stackTo, $numbers);
                return 0;
            default:
                return -1;

        }

    }

    private function moveCrates9000(Stack $stackFrom, Stack $stackTo, int $numbers)
    {
        /**
         * @var Move $move
         */
        for ($i = 0; $i < $numbers; $i++) {
            try {
                if (!$stackFrom->isEmpty()) {
                    $crate = $stackFrom->getTopCrate();
                    $stackTo->addCrate($crate);
                    $stackFrom->removeCrate($crate);
                }
            } catch (\Error|\Exception $e) {
                continue;
            }

        }
    }

    private function moveCrates9001(Stack $stackFrom, Stack $stackTo, int $numbers)
    {
        try {
            $crates = $stackFrom->getTopCrates($numbers);
            foreach ($crates as $crate) {
                if (isset($crate)) {
                    $stackTo->addCrate($crate);
                    $stackFrom->removeCrate($crate);
                }

            }
        } catch (\Error|\Exception $e) {
            $this->logger->error($e->getMessage());
            return -1;
        }
        return 0;
    }

}
