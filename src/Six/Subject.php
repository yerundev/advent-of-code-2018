<?php

namespace Aoc\Six;

class Subject
{
    public function __construct(int $x, int $y, string $name)
    {
        $this->x = $x;
        $this->y = $y;
        $this->name = $name;
    }

    public function manhattan(int $x, int $y)
    {
        return abs($this->x - $x) + abs($this->y - $y);
    }

    public function __toString()
    {
        return $this->name;
    }
}