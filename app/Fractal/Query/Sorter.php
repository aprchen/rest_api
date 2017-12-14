<?php

namespace App\Fractal\Query;
/**
 * @author Olivier Andriessen olivierandriessen@gmail.com Bart Blok bart@wittig.nl
 * @source(redound/phalcon-api)
 */
class Sorter
{
    const ASCENDING = 0;
    const DESCENDING = 1;

    protected $field;
    protected $direction;

    public function __construct($field, $direction)
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getDirection()
    {
        return $this->direction;
    }
}
