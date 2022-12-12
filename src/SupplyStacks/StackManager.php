<?php

namespace App\SupplyStacks;

use App\SupplyStacks\Model\Crate;
use App\SupplyStacks\Model\Stack;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class StackManager
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

    }

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
        throw new ResourceNotFoundException(sprintf('Le Stack [%d] n\'existe pas', $id));
    }

    public function getTopCrates(array $stacks): array
    {
        $topCrates = [];
        try {
            foreach ($stacks as $stack) {
                /**
                 * @var Stack $stack
                 */
                $topCrates [] = ($stack->getTopCrate() instanceof Crate) ? $stack->getTopCrate()->getLetter() : '';
            }

        } catch (\Error|\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $topCrates;
    }

}
