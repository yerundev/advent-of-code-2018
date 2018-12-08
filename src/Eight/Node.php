<?php

namespace Aoc\Eight;

class Node
{

    public function __construct(int $totalChildren, int $totalMetaEntries)
    {
        $this->totalChildren = $totalChildren;
        $this->totalMetaEntries = $totalMetaEntries;
        $this->metaEntries = [];
        $this->children = [];
    }

    public function pushMetaEntry(int $entry)
    {
        $this->metaEntries[] = $entry;
    }

    public function metaMissing() : bool
    {
        return $this->totalMetaEntries - count($this->metaEntries) > 0;
    }

    public function appendChild(Node $node)
    {
        $this->children[] = $node;
    }

    public function value() : int
    {
        if (count($this->children) == 0) {
            return $this->sum();
        }

        $value = 0;

        foreach ($this->metaEntries as $entry) {
            $index = $entry - 1;
            if ($index < count($this->children) && $index >= 0) {
                $value += $this->children[$index]->value();
            }
        }

        return $value;
    }

    public function sum()
    {
        return array_sum($this->metaEntries);
    }
}