<?php

namespace SunnyFlail\Dumper\Data;

class PropertyData implements IData
{
    
    use DataTrait;

    public function __construct(
        protected array $propertyTypes,
        protected string $propertyName,
        protected string $propertyModifier,
        protected bool $propertyStatic,
        protected IData $value
    )
    {
        $this->type = "property__$propertyName";
    }

}