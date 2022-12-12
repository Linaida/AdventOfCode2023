<?php

namespace App\SupplyStacks;

use App\File\FileSplitter;
use App\SupplyStacks\Model\Crate;
use App\SupplyStacks\Model\Move;
use App\SupplyStacks\Model\Schema;
use App\SupplyStacks\Model\Stack;
use Psr\Log\LoggerInterface;

class SupplyStacksService
{

    private FileSplitter $fileSplitter;
    private StackManager $stackManager;
    private CraneOperator $craneOperator;

    private LoggerInterface $logger;

    public function __construct(FileSplitter $fileSplitter, StackManager $stackManager, CraneOperator $craneOperator, LoggerInterface $logger)
    {
        $this->fileSplitter = $fileSplitter;
        $this->stackManager = $stackManager;
        $this->craneOperator = $craneOperator;
        $this->logger = $logger;
    }

    public function run(string $content)
    {

        $schema1 = $this->getSchemaFromContent($content);
        $part1 = $this->runPart1($schema1);
        $schema2 = $this->getSchemaFromContent($content);
        $part2 = $this->runPart2($schema2);

        return ['part1' => $part1,'part2' => $part2];

    }

    public function runPart1(Schema $schema)
    {
        $stacks = $this->moveCrates($schema->getMoves(), $schema->getStacks(), CraneOperator::CRANE_OPERATOR_9000);
        $topCrates = $this->stackManager->getTopCrates($stacks);
        return implode('', $topCrates);
    }

    public function runPart2(Schema $schema)
    {
        $stacks = $this->moveCrates($schema->getMoves(), $schema->getStacks(), CraneOperator::CRANE_OPERATOR_9001);
        $topCrates = $this->stackManager->getTopCrates($stacks);
        return implode('', $topCrates);
    }

    public function parseLines(string $schema): Schema
    {
        $lines = $this->fileSplitter->splitNewLine($schema);
        $cratesLine = [];
        $indexes = [];
        foreach ($lines as $line) {
            $match = [];
            if (preg_match_all('/\[.\]|\s{4}/', $line, $match)) {
                $cratesLine [] = $match[0];
            }
            if (preg_match_all('/\d/', $line, $match)) {
                $indexes = $match[0];
            }
        }
        $schema = new Schema();
        return $schema->setLinesStacks($cratesLine)->setIndexes($indexes);
    }

    private function getStacks(Schema $schema): Schema
    {
        $list = [];
        $arrayStacks = $schema->getLinesStacks();
        foreach ($schema->getIndexes() as $index) {
            $stack = new Stack();
            $stack->setId($index);
            $column = array_column($arrayStacks, $index - 1);
            $stack->getCratesFromArray($column);
            $list [] = $stack;
        }

        return $schema->setStacks($list);

    }

    public function getSchemaFromContent(string $content): Schema
    {
        $schemaContent = $this->fileSplitter->splitBlankLine($content)[0];
        $schema = $this->parseLines($schemaContent);
        $schema = $this->getStacks($schema);
        $moves = $this->getMovesFromContent($content);
        $schema->setMoves($moves);
        return $schema;
    }

    public function getMovesFromContent(string $content): array
    {
        $moves = [];
        $movesContent = $this->fileSplitter->splitBlankLine($content)[1];
        $lines = $this->fileSplitter->splitNewLine($movesContent);
        foreach ($lines as $line) {
            if (preg_match_all('/(\d+)|(\d+)|(\d+)/', $line, $match)) {
                $move = new Move();
                $move->setNumbers((int)$match[0][0])
                    ->setFrom((int)$match[0][1])
                    ->setTo((int)$match[0][2]);
                $moves [] = $move;

            }
        }
        return $moves;

    }

    private function moveCrates(array $moves, array $stacks, int $craneOperator)
    {
        foreach ($moves as $move) {

            $stackFrom = $this->stackManager->getStackFromId($stacks, $move->getFrom());
            $stackTo = $this->stackManager->getStackFromId($stacks, $move->getTo());
            $this->craneOperator->move($stackFrom, $stackTo, $move->getNumbers(), $craneOperator);

        }
        return $stacks;
    }


}
