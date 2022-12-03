<?php

namespace App\RockPaperScissors\Enum;

enum HandShapeEnum
{
    public const ROCK = 'A';
    public const PAPER = 'B';
    public const SCISSORS = 'C';

    public const ROCK_PLAYER = 'X';
    public const PAPER_PLAYER = 'Y';
    public const SCISSORS_PLAYER = 'Z';

    public static function getPoints(string $hand): int
    {
        return match ($hand) {
            self::ROCK, self::ROCK_PLAYER => 1,
            self::PAPER, self::PAPER_PLAYER => 2,
            self::SCISSORS, self::SCISSORS_PLAYER => 3,
            default => 0,
        };
    }

}
