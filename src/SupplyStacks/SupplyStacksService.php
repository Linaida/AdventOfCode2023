<?php

namespace App\SupplyStacks;

use App\File\FileSplitter;
use App\SupplyStacks\Model\Crate;
use App\SupplyStacks\Model\Move;
use App\SupplyStacks\Model\Schema;
use App\SupplyStacks\Model\Stack;

class SupplyStacksService
{


    private FileSplitter $fileSplitter;
    private StackManager $stackManager;

    public function __construct(FileSplitter $fileSplitter, StackManager $stackManager)
    {
        $this->fileSplitter = $fileSplitter;
        $this->stackManager = $stackManager;
    }

    public function runPart1(string $content)
    {
        $schemaContent = $this->getSchemaFromContent($content);

        $schema = $this->parseLines($schemaContent);
        $stacks = $this->getStacks($schema);
        $moves = $this->getMovesFromContent($content);
        $newStacks = $this->moveCrates($moves, $stacks);
        $topCrates = $this->stackManager->getTopCrates($stacks);
        return implode('',$topCrates);

    }

    public function parseLines(string $schema): Schema
    {
        $lines = $this->fileSplitter->splitNewLine($schema);
        $cratesLine = [];
        $indexes = [];
        foreach ($lines as $line) {
            $match = [];
            if(preg_match_all('/\[.\]|\s{4}/',$line, $match)) {
                $cratesLine []= $match[0];
            }
            if(preg_match_all('/\d/',$line, $match)) {
                $indexes = $match[0];
            }
        }
        $schema = new Schema();
        $schema->setStacks($cratesLine)->setIndexes($indexes);
        return $schema;
    }

    private function getStacks(Schema $schema): array
    {
        $list = [];
        $arrayStacks = $schema->getStacks();
        foreach ($schema->getIndexes() as $index) {
            $stack = new Stack();
            $stack->setId($index);
            $column = array_column($arrayStacks, $index -1);
            $stack->getCratesFromArray($column);
            $list []= $stack;
        }
        return $list;

    }

    public function getSchemaFromContent(string $content): string
    {
        return $this->fileSplitter->splitBlankLine($content)[0];

    }
    public function getMovesFromContent(string $content): array
    {
        $moves = [];
        $movesContent =  $this->fileSplitter->splitBlankLine($content)[1];
        $lines = $this->fileSplitter->splitNewLine($movesContent);
        foreach ($lines as $line) {
            if(preg_match_all('/(\d+)|(\d+)|(\d+)/',$line, $match)) {
                $move = new Move();
                $move->setNumbers((int)$match[0][0])
                ->setFrom((int)$match[0][1])
                ->setTo((int)$match[0][2]);
                $moves []= $move;

            }
        }
        return $moves;

    }

    private function moveCrates(array $moves, array $stacks)
    {
        foreach ($moves as $move) {
            /**
             * @var Move $move
             */
            for ($i=0; $i < $move->getNumbers(); $i++) {
                try {
                    $stackFrom = $this->stackManager->getStackFromId($stacks, $move->getFrom());
                    $stackTo = $this->stackManager->getStackFromId($stacks, $move->getTo());
                    if(!$stackFrom->isEmpty()) {
                        $crate = $stackFrom->getTopCrate();
                        $stackTo->addCrate($crate);
                        $stackFrom->removeCrate($crate);
                    }

                }catch (\Error|\Exception $e) {
                    continue;
                }

            }
        }
        return $stacks;
    }


}
