<?php

namespace Aoc\Two;

use Aoc\BaseAocCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class TwoCommand extends BaseAocCommand
{

    protected function configure()
    {
        $this->setName('day-two')
            ->setDescription('Run day two of AoC 2018')
            ->addArgument('input', InputArgument::REQUIRED, 'The input file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->readFile($input->getArgument('input'), 'string');

        $totalOccurances = array_fill(2, 2, 0);

        foreach ($this->data as $word) {

            $occurances = array_unique(array_values($this->letterOccurances($word, 2, 3)));

            foreach ($occurances as $occurance) {
                $totalOccurances[$occurance]++;
            }
        }

        $checksum = array_product($totalOccurances);
        $output->writeln("Part one: {$checksum}");

        $found = false;

        foreach ($this->data as $index => $word) {
            
            if ($index == count($this->data) || $found) {
                break;
            }

            foreach (array_slice($this->data, $index + 1) as $other) {

                $commonSubStr = $this->common($word, $other);

                if (strlen($word) - strlen($commonSubStr) == 1) {
                    $output->writeln("Part two: {$commonSubStr}");
                    $found = true;
                    break;
                }
            }
        }
    }

    private function letterOccurances(string $string, int $min, int $max)
    {
        $occurances = [];
        
        $letters = array_unique(str_split($string));

        foreach ($letters as $letter) {
            $count = substr_count($string, $letter);
            if ($count >= $min && $count <= $max) {
                $occurances[$letter] = $count;
            }
        }

        return $occurances;
    }

    private function common(string $str1, string $str2)
    {   
        $nbrBottom = strspn($str1 ^ $str2, "\0");
        $nbrTop = strspn(strrev($str1) ^ strrev($str2), "\0");

        $bottom = substr($str1, 0, $nbrBottom);
        $top = substr($str1, strlen($str1) - $nbrTop);
        return $bottom . $top;
    }

}