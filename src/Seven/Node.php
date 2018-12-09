<?php

namespace Aoc\Seven;

class Node
{
    const ID_VALUE = [
        'A' => 1, 
        'B' => 2, 
        'C' => 3, 
        'D' => 4, 
        'E' => 5, 
        'F' => 6,
        'G' => 7,
        'H' => 8,
        'I' => 9,
        'J' => 10,
        'K' => 11,
        'L' => 12,
        'M' => 13,
        'N' => 14,
        'O' => 15,
        'P' => 16,
        'Q' => 17,
        'R' => 18,
        'S' => 19,
        'T' => 20,
        'U' => 21,
        'V' => 22,
        'W' => 23,
        'X' => 24,
        'Y' => 25,
        'Z' => 26,
    ];

    private $id;
    private $prerequisites;
    private $children;
    private $root;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->root = true;
        $this->children = [];
        $this->prerequisites = [];
    }

    public function addChild(Node $node)
    {
        $this->children[] = $node;
    }

    public function addPrerequisite(Node $node)
    {
        $this->prerequisites[] = $node->id;
        $this->root = false;
    }

    public function start(int $tick)
    {
        $this->deadline = $tick + 60 + self::ID_VALUE[$this->id];
    }

    public function done(int $tick)
    {
        return $tick >= $this->deadline;
    }

    public function open(array $visited)
    {
        foreach ($this->prerequisites as $pre) {
            if (!in_array($pre, $visited)) {
                return false;
            }
        }
        return true;
    }

    public function id()
    {
        return $this->id;
    }

    public function children()
    {
        return $this->children;
    }

    public function isRoot()
    {
        return $this->root;
    }
}