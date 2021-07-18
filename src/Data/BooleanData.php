<?php

namespace SunnyFlail\Dumper\Data;

class BooleanData implements IData
{

    use DataTrait;

    protected string $value;

    public function __construct(
        mixed $value
    ) {
        if ($value) {
            $this->value = 'true';
        } else {
            $this->value = 'false';
        }

        $this->type = 'boolean';
    }

}