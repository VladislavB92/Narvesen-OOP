<?php

declare(strict_types=1);

class CurrencyFormater
{
    public static function formatToDecimal($currency)
    {
        return $currency /= 100;
    }
}
