<?php

namespace Aoc\Seven;

use Aoc\BaseAocCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class SevenCommand extends BaseAocCommand
{
    protected function configure()
    {
        $this->setName('day-seven')
            ->setDescription('Run day seven of AoC 2018')
            ->addArgument('input', InputArgument::REQUIRED, 'The input file');
    }

    protected function day(InputInterface $input, OutputInterface $output)
    {   
        
        $this->readFile($input->getArgument('input'), 'string');
        $graph = $this->constructGraph($this->data);
        $order = [];
        $graph->traverse($order, 1);
        $output->writeln('Part one: ' . implode('', $order));

        $ticks = $graph->traverse($order, 5);
        $output->writeln('Part two: ' . $ticks);
    }

    public function constructGraph($input)
    {
        $graph = new Graph();

        foreach ($input as $line) {
            $node = $graph->findOrCreate($line['node']);
            $pre = $graph->findOrCreate($line['pre']);
            $node->addPrerequisite($pre);
            $pre->addChild($node);
        }

        return $graph;
    }

    protected function transformLine(string $line)
    {
        preg_match('/Step (?<pre>[A-Z]) must be finished before step (?<node>[A-Z]) can begin\./', $line, $matches);
        return $matches;
    }
}