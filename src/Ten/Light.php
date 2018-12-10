<?php

namespace Aoc\Ten;

class Light
{
    public function __construct(int $x, int $y, int $vx, int $vy)
    {
        $this->x = $x;
        $this->y = $y;
        $this->vy = $vy;
        $this->vx = $vx;
    }

    public function move()
    {
        $this->x += $this->vx;
        $this->y += $this->vy;
    }

    public function reverse()
    {
        $this->x -= $this->vx;
        $this->y -= $this->vy;
    }

    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }
}