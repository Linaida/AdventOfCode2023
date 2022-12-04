<?php

namespace App\RockPaperScissors;

use App\File\EventInputReader;
use App\File\FileSplitter;

class FileInputManager
{
    private FileSplitter $fileSplitter;
    private EventInputReader $eventInputReader;

    public function __construct(FileSplitter $fileSplitter, EventInputReader $eventInputReader)
    {
        $this->fileSplitter = $fileSplitter;
        $this->eventInputReader = $eventInputReader;
    }


    /**
     * @param int $day
     * @return string
     */
    public function getInputPath(int $day): string
    {
       return $this->eventInputReader->getInputPath($day);
    }
}
