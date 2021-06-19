<?php

namespace SunnyFlail\Dumper;

use ReflectionObject;
use ReflectionProperty;
use SunnyFlail\Dumper\Data\ArrayData;
use SunnyFlail\Dumper\Data\ArrayFieldData;
use SunnyFlail\Dumper\Data\IData;
use SunnyFlail\Dumper\Data\ObjectData;
use SunnyFlail\Dumper\Data\PropertyData;
use SunnyFlail\Dumper\Data\VariableData;
use SunnyFlail\Traits\GetTypesTrait;

abstract class AbstractDumper
{

    use GetTypesTrait;

    protected function resolve($var): IData
    {
        $type = gettype($var);

        switch ($type) {
            case "object": 
                $data = $this->resolveObject($var);
                break;
            case "array":
                $data = $this->resolveArray($var);
                break;
            default: 
                $data = $this->resolveVariable($var, $type);
        }

        return $data;
    }

    protected function resolveObject(object $object): ObjectData
    {
        $reflection = new ReflectionObject($object); 
        $properties = $reflection->getProperties();

        return new ObjectData(
            $reflection->getShortName(),
            $reflection->getNamespaceName(),
            array_keys($reflection->getInterfaces()),
            array_map(
                [$this, "resolveProperty"],
                $properties,
                $this->saturateArray($object, count($properties))
            )
        );
    }

    protected function resolveProperty(
        ReflectionProperty $property,
        object $object
    ) {
        $property->setAccessible(true);
        $propertyTypes = $this->getTypeStrings($property);
        $propertyName = $property->getName();
        $propertyModifier=$property->isPublic() ? "public"
                        : ($property->isPrivate() ? "private"
                        : ($property->isProtected() ? "protected"
                        : ""));
        $propertyStatic = $property->isStatic();
        
        $value = $property->getValue($object);
        $value = $this->resolve($value);

        return new PropertyData(
            $propertyTypes,
            $propertyName,
            $propertyModifier,
            $propertyStatic,
            $value
        );
    }

    protected function resolveArray(array $arr): ArrayData
    {
        $length = count($arr);

        $values = array_map(
            [$this, "resolveArrayField"],
            array_keys($arr),
            $arr
        );

        return new ArrayData($length, $values);
    }

    protected function resolveArrayField(string|int $key, mixed $value): ArrayFieldData
    {
        return new ArrayFieldData($key, $this->resolve($value));
    }

    protected function resolveVariable($var, string $type): VariableData
    {
        return new VariableData($type, $var);
    }

    protected function saturateArray($var, int $times): array
    {
        $arr = [];
        for ($i = 0; $i < $times; $i ++) {
            $arr[] = $var;
        }
        return $arr;
    }

    public abstract function dump($var);

}