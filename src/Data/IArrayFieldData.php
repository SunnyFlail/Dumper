<?php

namespace SunnyFlail\Dumper\Data;

interface IArrayFieldData extends IData
{

    public function getKey(): string|int;

}