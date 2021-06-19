<?php

namespace SunnyFlail\Dumper\Data;

class ObjectData implements IData 
{

    use DataTrait;

    public function __construct(
        protected string $class,
        protected string $namespace,
        protected array $interfaces,
        protected array $properties
    ) {
        $this->type = "object";
    }
    
}