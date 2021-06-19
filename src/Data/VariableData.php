<?php

namespace SunnyFlail\Dumper\Data;

class VariableData implements IData
{

    use DataTrait;

    public function __construct(
        string $type,
        protected mixed $value
    )
    {
        $this->type = $type;
    }

}