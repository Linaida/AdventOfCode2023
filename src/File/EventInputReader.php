<?php

namespace App\File;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class EventInputReader
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getInputPath(int $day)
    {
        $fs = new Filesystem();
        $filename = sprintf('day%sinput.txt',$day);
        $inputPath = Path::makeAbsolute( join(DIRECTORY_SEPARATOR,['public','files',$filename]),$this->projectDir);
        if (!$fs->exists($inputPath)) {
            throw new FileNotFoundException(sprintf('Fichier inexistant [%s]', $inputPath));
        }
        return $inputPath;
    }

}
