<?php

namespace Aoc;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $executionStartTime = microtime(true);
        
        $this->day($input, $output);

        $executionEndTime = microtime(true);
        
        $seconds = $executionEndTime - $executionStartTime;
        
        $output->writeln($seconds);
    }

    abstract protected function day(InputInterface $input, OutputInterface $output);
}