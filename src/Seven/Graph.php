<?php

namespace Aoc\Seven;

class Graph
{
    private $lookupTable;

    public function __construct($output)
    {
        $this->lookupTable = [];
        $this->output = $output;
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

    public function traverse(array &$order)
    {
        $roots = $this->getRoots();
        
        $freeNodes = $roots; 
        $visited = [];
        // $tick = 0;

        while (count($freeNodes) > 0) {
            
            usort($freeNodes, function ($a, $b) {
                return strcmp($a->id(), $b->id());
            });

            $node = $freeNodes[0];
            $visited[] = $node->id();
            unset($freeNodes[0]);

            foreach ($node->children() as $child) {
                if ($child->open($visited)) {
                    $freeNodes[] = $child;
                }
            }

            $order[] = $node->id(); 
        }
    }

    private function getRoots()
    {
        return array_filter(array_values($this->lookupTable), function ($node) {
            return $node->isRoot();
        });
    }

}