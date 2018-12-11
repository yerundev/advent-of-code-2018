<?php

namespace Aoc\Six;

class Map
{
    public function __construct(int $width, int $height, $output)
    {
        $this->output = $output;
        $this->height = $height;
        $this->width = $width;
        $this->map = array_fill(0, $height, array_fill(0, $width, '.'));
        $this->subjects = [];
    }

    public function addSubjects(array $subjects)
    {
        $this->subjects = $subjects;
    }

    public function calculate()
    {
        $subjectCount = array_fill_keys(array_map(function ($subject) { return $subject->name; }, $this->subjects), 0);
        
        for ($y = 0; $y < count($this->map); $y++) {
            for ($x = 0; $x < count($this->map[$y]); $x++) {

                $subject = $this->closestSubject($x, $y);
     
                if ($y == 0 || $y == ($this->height - 1) || $x == 0 || $x == ($this->width - 1)) {
                    unset($subjectCount[(string) $subject]);
                }

                if (array_key_exists((string) $subject, $subjectCount)) {
                    $subjectCount[(string) $subject] += 1;
                }
                $this->map[$y][$x] = $subject;
            }
        }

        return max(array_values($subjectCount));
    }

    public function print()
    {
        foreach ($this->map as $row) {
            $this->output->writeln(implode('', $row));
        }
    }

    public function closestSubject(int $x, int $y)
    {
        $distances = [];

        foreach ($this->subjects as $subject) {
            $dist = $subject->manhattan($x, $y);
            $distances[$dist][] = $subject;
        }

        $minimum = min(array_keys($distances));

        if (count($distances[$minimum]) > 1) {
            return '.';
        }

        return $distances[$minimum][0];
    }
}