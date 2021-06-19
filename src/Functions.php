<?php

use SunnyFlail\Dumper\ConsoleDumper;
use SunnyFlail\Dumper\WebDumper;

if (!function_exists("dump")) {
    if (php_sapi_name() === "cli") {
        function dump($var) {
            $dumper = new ConsoleDumper();
            echo $dumper->dump($var);
        }
    } else {
        function dump($var) {
            echo WebDumper::get()->dump($var);
        }
    }
}