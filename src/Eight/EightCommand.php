<?php

namespace Aoc\Eight;

use Aoc\BaseAocCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class EightCommand extends BaseAocCommand
{
    protected function configure()
    {
        $this->setName('day-eight')
            ->setDescription('Run day eight of AoC 2018')
            ->addArgument('input', InputArgument::REQUIRED, 'The input file');
    }

    protected function day(InputInterface $input, OutputInterface $output)
    {   
        $this->output = $output;
        $this->readFile($input->getArgument('input'), 'string');
        
        $input = $this->data[0];
        $nodes = [];

        $this->constructGraph($input, 0, $nodes);

        $sum = 0;
        
        foreach ($nodes as $node) {
            $sum += $node->sum();
        }

        $output->writeln('Part one: ' . $sum);

        $root = $nodes[count($nodes) - 1];

        $output->writeln('Part two: ' . $root->value());
        
    }

    private function constructGraph($input, $index, &$nodes, &$parent = null)
    {
        $children = $input[$index];
        $meta = $input[$index+1];
        $index += 2;
        
        $node = new Node($children, $meta);
        
        if ($parent) {
            $parent->appendChild($node);
        }
        
        while ($children > 0) {
            $index = $this->constructGraph($input, $index, $nodes, $node);
            $children--;
        }

        $nodes[] = $node;

        while ($node->metaMissing()) {
            $node->pushMetaEntry($input[$index]);
            $index++;
        }

        return $index;
    }

    protected function transformLine(string $line)
    {
        return preg_split('/\s/', trim($line));
    }
}