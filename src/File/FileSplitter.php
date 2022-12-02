<?php

namespace App\File;

class FileSplitter
{

    public function splitNewLine(string $content)
    {
        return preg_split('/(\r\n)/',$content);
    }


    public function splitBlankLine(string $content)
    {
        return preg_split('/(\r\n\r\n)/',$content);
    }
}