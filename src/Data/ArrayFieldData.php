<?php

namespace SunnyFlail\Dumper\Data;

class ArrayFieldData implements IArrayFieldData
{

    use DataTrait;

    public function __construct(
        protected string $key,
        protected IData $value
    )
    {
        $this->type = $key;        
    }

    public function getKey(): string
    {
        return $this->key;
    }

}