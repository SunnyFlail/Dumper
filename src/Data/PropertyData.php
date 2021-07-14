<?php

namespace SunnyFlail\Dumper\Data;

class PropertyData implements IData
{
    
    use DataTrait;

    public function __construct(
        protected array $types,
        protected string $name,
        protected string $modifier,
        protected bool $static,
        protected IData $value
    )
    {
        $this->type = $name;
    }

}