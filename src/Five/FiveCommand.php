<?php

namespace Aoc\Five;

use Aoc\BaseAocCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class FiveCommand extends BaseAocCommand
{
    protected function configure()
    {
        $this->setName('day-five')
            ->setDescription('Run day five of AoC 2018')
            ->addArgument('input', InputArgument::REQUIRED, 'The input file');
    }

    protected function day(InputInterface $input, OutputInterface $output)
    {   
        $this->readFile($input->getArgument('input'), 'string');
        
        $polymer = new Polymer($this->data[0], $output);
        $polymer->react();

        $output->writeln($polymer->units());
    }
}