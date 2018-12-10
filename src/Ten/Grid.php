<?php

namespace Aoc\Ten;

class Grid
{
    public function __construct()
    {
        $this->lights = [];
    }

    public function push(Light $light)
    {
        $this->lights[] = $light;
    }

    public function tick()
    {
        foreach ($this->lights as $light) {
            $light->move();
        }
    }

    public function untick()
    {
        foreach ($this->lights as $light) {
            $light->reverse();
        }
    }

    public function area()
    {
        $horizontal = array_map(function ($light) { return $light->getX(); }, $this->lights);
        $vertical = array_map(function ($light) { return $light->getY(); }, $this->lights);
        
        $maxX = max($horizontal);
        $minX = min($horizontal);

        $maxY = max($vertical);
        $minY= min($vertical);

        return ($maxX - $minX) * ($maxY - $minY); 
    }

    public function print($output)
    {
        $horizontal = array_map(function ($light) { return $light->getX(); }, $this->lights);
        $vertical = array_map(function ($light) { return $light->getY(); }, $this->lights);
        
        $maxX = max($horizontal);
        $minX = min($horizontal);

        $maxY = max($vertical);
        $minY= min($vertical);

        foreach (range($minY, $maxY) as $y) {
            $row = '';
            foreach (range($minX, $maxX) as $x) {
                $light = array_filter($this->lights, function ($light) use($x, $y) {
                    return $light->getX() == $x && $light->getY() == $y;
                });

                if (count($light) > 0) {
                    $row .= '#';
                } else {
                    $row .= '.';
                }
            }
            $output->writeln($row);
        }
    }
}