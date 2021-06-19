<?php

namespace SunnyFlail\Dumper\Data;

class ArrayData implements IData
{

    use DataTrait;

    public function __construct(
        protected int $length,
        protected array $values
    )
    {
       $this->type = "array";
    }

}