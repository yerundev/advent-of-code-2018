<?php

namespace Aoc;

use Symfony\Component\Console\Command\Command;

abstract class BaseAocCommand extends Command
{
    protected $data = [];

    public function readFile(string $file, string $type)
    {
        if ($file = fopen($file, 'r')) {
            while (!feof($file)) {
                $line = fgets($file);
                if (!empty($line)) {
                    settype($line, $type);
                    $this->data[] = $line;
                }
            }
            fclose($file);
        }
    }
}