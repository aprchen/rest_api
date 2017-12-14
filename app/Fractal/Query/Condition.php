<?php

namespace App\Fractal\Query;
/**
 * Class Condition
 * @author Olivier Andriessen olivierandriessen@gmail.com Bart Blok bart@wittig.nl
 * @source(redound/phalcon-api)
 */
class Condition
{
    const TYPE_AND = 0;
    const TYPE_OR = 1;

    public $type;
    public $field;
    public $operator;
    public $value;

    public function __construct($type, $field, $operator, $value)
    {
        $this->type = $type;
        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function getValue()
    {
        return $this->value;
    }
}
