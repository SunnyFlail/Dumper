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
            $value = 'true';
        } else {
            $value = 'false';
        }

        $this->type = 'boolean';
    }

}