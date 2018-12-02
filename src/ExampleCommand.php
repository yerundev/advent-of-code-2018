<?php

namespace Aoc;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ExampleCommand extends Command
{
    protected function configure()
    {
        $this->setName('example')
            ->setDescription('An example command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("hello my dude");
    }
}