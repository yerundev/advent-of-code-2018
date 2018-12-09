<?php

namespace Aoc\Seven;

class Graph
{
    private $lookupTable;

    public function __construct()
    {
        $this->lookupTable = [];
    }

    public function addNode(Node $node)
    {
        if (! in_array($node->id(), array_keys($this->lookupTable))) {
            $this->lookupTable[$node->id()] = $node; 
        }
    }

    public function findOrCreate(string $id)
    {
        if (in_array($id, array_keys($this->lookupTable))) {
            return $this->lookupTable[$id];
        }

        $node = new Node($id);
        $this->lookupTable[$id] = $node;

        return $node;
    }

    public function traverse(array &$order, int $workers)
    {
        $roots = $this->getRoots();
        
        $freeNodes = $roots; 
        $visited = [];
        $pending = [];
        $tick = 0;

        while (count($visited) < count(array_values($this->lookupTable))) {
            
            foreach ($pending as $index => $pendingNode) {
                if ($pendingNode->done($tick)) {
                    $workers++;
                    $order[] = $pendingNode->id();
                    $visited[] = $pendingNode->id();
                    unset($pending[$index]);
                    foreach ($pendingNode->children() as $child) {
                        if ($child->open($visited)) {
                            $freeNodes[] = $child;
                        }
                    }
                }
            }

            while (count($freeNodes) > 0 && $workers > 0) {
                usort($freeNodes, function ($a, $b) {
                    return strcmp($a->id(), $b->id());
                });
                $node = $freeNodes[0];
                $node->start($tick);
                $pending[] = $node;
                unset($freeNodes[0]);
                $workers = $workers - 1;
            }
            $tick++;
            
        }

        return $tick - 1;
    }

    private function getRoots()
    {
        return array_filter(array_values($this->lookupTable), function ($node) {
            return $node->isRoot();
        });
    }

}