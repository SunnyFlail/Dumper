<?php

namespace SunnyFlail\Dumper;

use ArrayIterator;
use SunnyFlail\Dumper\Data\IData;

final class WebDumper extends AbstractDumper
{

    public static ?WebDumper $SINGLETON = null;
    private bool $cssDumped;

    public function __construct(
        private string $hashName,
        private string $css,
        private string $arrTemplate
    )
    {
        $this->cssDumped = false;
    }

    public function dump($var)
    {
        $string = $this->prettyPrint($this->resolve($var));
        $string = sprintf("<div class='dump_bg'>%s</div>");

        if (!$this->cssDumped) {
            $string = $this->css.$string;
            $this->cssDumped = true;
        }

        return $string;
    }

    private function prettyPrint(IData|array $data): string
    {
        $string = "<div class='dump_wr'>";

        if (is_array($data)) {
            $iterator = new ArrayIterator($data);
        } else {
            /** @var ArrayIterator $iterator */
            $iterator = $data->getIterator();
        }

        while ($iterator->valid()) {
            $key = $iterator->key();
            $value = $iterator->current();

            $string .= "<div class='dump_bo'>";
            if (is_array($value)) {
                $id = $this->generateRandomName();

                $string .= sprintf(
                    $this->arrTemplate,
                    $id,
                    $key,
                    $this->prettyPrint($value)
                );
            } else {
                $string .= "<div class='dump_l'>
                                <span class='dump_t'>$key:</span>
                                <span class='dump_v'>$value</span>
                            </div>";
            }
            $string .= "</div>";

            $iterator->next();
        }

        $string .= "</div>";

        return $string;
    }

    private function generateRandomName(): string
    {
        return hash($this->hash, random_bytes(64));
    }

    public static function get(): self
    {
        if (!is_null(self::$SINGLETON)) {
            $hashes = hash_algos();
            $fastHashes = [
                "crc32b",
                "crc32",
                "crc32c",
                "adler32",
                "md4"
            ];
            $css = file_get_contents("Assets/style.css");
            $css = sprintf("<style>%s</style>", $css);
            $arrTemplate = file_get_contents("Assets/Template_Array.html");

            self::$SINGLETON = new self(
                array_intersect($hashes, $fastHashes)[0],
                $css,
                $arrTemplate
            );
        }

        return self::$SINGLETON;
    }

}