<?php

namespace SunnyFlail\Dumper\Data;

class PropertyData implements IPropertyData
{
    
    use DataTrait;

    public function __construct(
        protected array $types,
        protected string $name,
        protected string $modifier,
        protected string $static,
        protected string $initialised,
        protected IData|string $value
    ) {
        $this->type = $name;
    }

    public function getPropertyName(): string
    {
        return $this->name;
    }

}