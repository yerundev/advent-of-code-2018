<?php

namespace Aoc\Six;

use Aoc\BaseAocCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class SixCommand extends BaseAocCommand
{
    protected function configure()
    {
        $this->setName('day-six')
            ->setDescription('Run day six of AoC 2018')
            ->addArgument('input', InputArgument::REQUIRED, 'The input file');
    }

    protected function day(InputInterface $input, OutputInterface $output)
    {   
        $this->readFile($input->getArgument('input'), 'string');
        
        $map = new Map(10, 10, $output);

        $height = 0;
        $width = 0;
        $subjects = [];

        $n = 0;
        foreach ($this->data as $match) {
            $x = $match['x'];
            $y = $match['y'];
            
            if ($x > $width) {
                $width = $x;
            }
            
            if ($y > $height) {
                $height = $y;
            }

            $subjects[] = new Subject($x, $y, (string) $n);
            $n++;
        }
        $map = new Map($width+1, $height+1, $output);
        $map->addSubjects($subjects);
        $max = $map->calculate();
        $output->writeln($max);
    }

    protected function transformLine(string $line)
    {
        preg_match('/(?<x>[0-9]+)\, (?<y>[0-9]+)/', $line, $matches);
        return $matches;
    }
}