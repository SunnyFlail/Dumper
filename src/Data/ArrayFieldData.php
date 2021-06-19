<?php

namespace SunnyFlail\Dumper\Data;

class ArrayFieldData implements IData
{

    use DataTrait;

    public function __construct(
        protected string $key,
        protected IData $valueData
    )
    {
        $this->type = "field__$key";        
    }

}