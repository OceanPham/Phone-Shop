<?php

if (!function_exists('numberToWords')) {
    function numberToWords($number)
    {
        $ones = ['', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];

        if ($number == 0) return 'không';

        $result = '';

        // Process billions
        if ($number >= 1000000000) {
            $billions = intval($number / 1000000000);
            $result .= convertThreeDigits($billions) . ' tỷ ';
            $number %= 1000000000;
        }

        // Process millions
        if ($number >= 1000000) {
            $millions = intval($number / 1000000);
            $result .= convertThreeDigits($millions) . ' triệu ';
            $number %= 1000000;
        }

        // Process thousands
        if ($number >= 1000) {
            $thousands = intval($number / 1000);
            $result .= convertThreeDigits($thousands) . ' nghìn ';
            $number %= 1000;
        }

        // Process hundreds
        if ($number > 0) {
            $result .= convertThreeDigits($number);
        }

        return ucfirst(trim($result));
    }
}

if (!function_exists('convertThreeDigits')) {
    function convertThreeDigits($number)
    {
        $ones = ['', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
        $result = '';

        if ($number >= 100) {
            $result .= $ones[intval($number / 100)] . ' trăm ';
            $number %= 100;
        }

        if ($number >= 20) {
            $result .= $ones[intval($number / 10)] . ' mươi ';
            $number %= 10;
        } elseif ($number >= 10) {
            $result .= 'mười ';
            $number %= 10;
        }

        if ($number > 0) {
            $result .= $ones[$number];
        }

        return trim($result);
    }
}
