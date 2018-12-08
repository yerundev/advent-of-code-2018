<?php

namespace Aoc\Seven;

class Node
{
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