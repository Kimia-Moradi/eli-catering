<?php

if (! function_exists('fa_number')) {
    /**
     * Convert Western Arabic digits (0-9) to Persian digits (۰-۹), leaving
     * separators like commas untouched. Prices are stored and formatted
     * (number_format) as plain Latin-digit strings — this is applied only
     * at render time in the Blade views, so the underlying data stays
     * ordinary and easy to test.
     *
     * Example: fa_number('280,000') === '۲۸۰,۰۰۰'
     */
    function fa_number(string|int|float $value): string
    {
        static $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        static $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        return str_replace($western, $persian, (string) $value);
    }
}
