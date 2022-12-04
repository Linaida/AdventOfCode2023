<?php

namespace App\RockPaperScissors\Enum;

enum RoundScoreEnum
{
    public const DRAW = 3;
    public const LOST = 0;
    public const WON = 6;


    public const DRAW_PLAYER = 'Y';
    public const LOST_PLAYER = 'X';
    public const WON_PLAYER = 'Z';

}
