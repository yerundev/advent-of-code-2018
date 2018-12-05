<?php

namespace Aoc\Five;

class Polymer
{
    public function __construct(string $polymer)
    {
        $this->polymer = $polymer;
    }

    public function react()
    {
        $index = 0;
        while ($index < strlen($this->polymer) - 1) {       
            while ($direction = $this->reactionDirection($index)) {
                if ($direction == -1) {
                    // $this->polymer = substr_replace($this->polymer, '', $index - 1, 2);
                    // $index--;

                    $reagent = $this->polymer[$index] . $this->polymer[$index-1];
                    $this->polymer = str_replace("{$reagent}", '', $this->polymer);
                    $reagent = strrev($reagent);
                    $this->polymer = str_replace("{$reagent}", '', $this->polymer);
                    $index--;
                } else if ($direction == 1) {
                    //$this->polymer = substr_replace($this->polymer, '', $index, 2);

                    $reagent = $this->polymer[$index] . $this->polymer[$index+1];
                    $this->polymer = str_replace("{$reagent}", '', $this->polymer);
                    $reagent = strrev($reagent);
                    $this->polymer = str_replace("{$reagent}", '', $this->polymer);
                }
            }

            $index++;
        }
    }

    public function units()
    {
        return strlen($this->polymer);
    }

    private function reactionDirection(int $index)
    {
        if ($index < (strlen($this->polymer) - 1) && $this->canReact($this->polymer[$index], $this->polymer[$index+1])) {
            return 1;
        } 

        if ($index > 0 && $index < strlen($this->polymer) && $this->canReact($this->polymer[$index], $this->polymer[$index-1])) {
            return -1;
        }

        return 0;
    }

    private function canReact(string $unit1, string $unit2)
    {   
        return strtolower($unit1) == $unit2 && strtoupper($unit2) == $unit1
            || strtolower($unit2) == $unit1 && strtoupper($unit1) == $unit2;
    }
}