<?php

namespace SunnyFlail\Dumper\Data;

use ArrayIterator;
use Iterator;
use ReflectionObject;

trait DataTrait
{

    protected string $type;

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->jsonSerialize()[$this->type]);
    }

    public function jsonSerialize()
    {
        $reflection = new ReflectionObject($this);
        return [$this->type => array_reduce(
                $reflection->getProperties(),
                function (array $carry, \ReflectionProperty $current) {
                    $propName = $current->getName();
                    $current->setAccessible(true);
                    $carry[$propName] = $current->getValue($this);

                    return $carry;
                },
                []
            )
        ];
    }

    public function __toString(): string
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

}