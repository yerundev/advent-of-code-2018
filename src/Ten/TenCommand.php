<?php

namespace Aoc\Ten;

use Aoc\BaseAocCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class TenCommand extends BaseAocCommand
{
    protected function configure()
    {
        $this->setName('day-ten')
            ->setDescription('Run day ten of AoC 2018')
            ->addArgument('input', InputArgument::REQUIRED, 'The input file');
    }

    protected function day(InputInterface $input, OutputInterface $output)
    {   
        $this->readFile($input->getArgument('input'), 'string');
        
        // $a = ['a', 'b', 'a'];
        // $match = array_filter($a, function ($a) {
        //     return $a == 'c';
        // });
        // $output->writeln(var_dump($match));
        $grid = new Grid();
        foreach ($this->data as $match) {
            $x = $match[1];
            $y = $match[2];
            $vx = $match[3];
            $vy = $match[4];
            $grid->push(new Light($x, $y, $vx, $vy));
        }

        $prevArea = $grid->area();
        $diverging = false;
        $tick = 0;

        while (! $diverging) {
            $area = $grid->area();
            if ($area > $prevArea) {
                $diverging = true;
                $grid->untick();
                $grid->print($output);
                $tick--;
            } else {
                $tick++;
                $grid->tick();
                $prevArea = $area;
            }            
        }

        $output->writeln('Part two: ' . $tick);
    }

    protected function transformLine(string $line)
    {
        preg_match('/position\=\<([\s]?\d+|\-\d+)\, ([\s]?\d+|\-\d+)\> velocity\=\<([\s]?\d+|\-\d+)\, ([\s]?\d+|\-\d+)\>/', $line, $matches);
        return $matches;
    }
}