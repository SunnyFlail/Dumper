<?php

namespace SunnyFlail\Dumper;

final class ConsoleDumper extends AbstractDumper
{

    public function dump($var)
    {
        return (string) $this->resolve($var);
    }

}