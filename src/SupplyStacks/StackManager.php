<?php

namespace App\SupplyStacks;

use App\SupplyStacks\Model\Stack;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class StackManager
{
    public function getStackFromId(array $stacks, int $id)
    {
        foreach ($stacks as $stack) {
            if (!$stack instanceof Stack) {
                throw new \TypeError('L\'objet n\'est pas un Stack');
            }
            if ($stack->getId() === $id) {
                return $stack;
            }
        }
        throw new ResourceNotFoundException(sprintf('Le Stack [%d] n\'existe pas',$id));
    }

    public function getTopCrates(array $stacks): array
    {
        $topCrates = [];
        foreach ($stacks as $stack) {
            /**
             * @var Stack $stack
             */
            $topCrates []= $stack->getTopCrate()->getLetter();
        }
        return $topCrates;
    }

}
