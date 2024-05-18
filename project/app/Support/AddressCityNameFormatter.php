<?php

namespace App\Support;

class AddressCityNameFormatter
{
    public static function formatCityName(string $name): string
    {
        $prepositions = ['e', 'de', 'da', 'do', 'dos', 'das'];
        $words = explode(' ', mb_strtolower($name));

        foreach ($words as $key => $word) {
            if (!in_array($word, $prepositions)) {
                $words[$key] = mb_convert_case($word, MB_CASE_TITLE, "UTF-8");
            }
        }

        return implode(' ', $words);
    }
}
