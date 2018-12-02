<?php

namespace Aoc\One;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class OneCommand extends Command
{
    private $data;

    public function __construct()
    {
        parent::__construct();
        $this->data = [];
    }

    protected function configure()
    {
        $this->setName('day-one')
            ->setDescription('Run day one of AoC 2018')
            ->addArgument('input', InputArgument::REQUIRED, 'The input file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->readFile($input->getArgument('input'));

        $sum = array_sum($this->data);
        $output->writeln("Part one: {$sum}");

        $frequencies = [];
        $frequency = 0;
        $found = false;

        while (! $found) {
            foreach ($this->data as $difference) {
                $frequency += $difference;
                if (array_key_exists($frequency, $frequencies)) {
                    $output->writeln("Part two: {$frequency}");
                    $found = true;
                    break;
                }
                $frequencies[$frequency] = 1;
            }
        }
    }

    private function readFile(string $file)
    {
        if ($file = fopen($file, 'r')) {
            while (!feof($file)) {
                $line = fgets($file);
                if (!empty($line)) {
                    $this->data[] = (int) $line;
                }
            }
            fclose($file);
        }
    }
}