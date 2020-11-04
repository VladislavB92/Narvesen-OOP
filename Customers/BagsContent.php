<?php

declare(strict_types=1);

class BagsContent
{
    public static function showBagsContent(array $bag): string
    {
        foreach ($bag as $product => $amount) {
            return implode(', ', array_map(
                function ($v, $k) {
                    if (substr($k, -1) !== "s") {
                        return $v . " " . $k . "s";
                    }
                    return $v . " " . $k . "";
                },
                $bag,
                array_keys($bag)
            ));
        }
    }
}
