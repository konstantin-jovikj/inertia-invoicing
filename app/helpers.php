<?php

if (!function_exists('latinToCyrillic')) {
    function latinToCyrillic($string)
    {
        $multiCharMap = [
            'kj' => 'ќ',
            'Kj' => 'Ќ',
            'KJ' => 'Ќ',
            'R.N.Macedonia' => 'Р.С.Македонија',
            'Понуда' => 'Offer',
            'Про-Фактура' => 'Proforma-Invoice',
            'Фактура' => 'Invoice',
            'Пакинг-Листа' => 'Packing-List',
        ];

        foreach ($multiCharMap as $latin => $cyrillic) {
            $string = str_replace($latin, $cyrillic, $string);
        }

        $singleCharMap = [
            'A' => 'А', 'B' => 'Б', 'C' => 'Ц', 'D' => 'Д', 'E' => 'Е',
            'F' => 'Ф', 'G' => 'Г', 'H' => 'Х', 'I' => 'И', 'J' => 'Ј',
            'K' => 'К', 'L' => 'Л', 'M' => 'М', 'N' => 'Н', 'O' => 'О',
            'P' => 'П', 'R' => 'Р', 'S' => 'С', 'T' => 'Т', 'U' => 'У',
            'V' => 'В', 'Z' => 'З', 'a' => 'а', 'b' => 'б', 'c' => 'ц',
            'd' => 'д', 'e' => 'е', 'f' => 'ф', 'g' => 'г', 'h' => 'х',
            'i' => 'и', 'j' => 'ј', 'k' => 'к', 'l' => 'л', 'm' => 'м',
            'n' => 'н', 'o' => 'о', 'p' => 'п', 'r' => 'р', 's' => 'с',
            't' => 'т', 'u' => 'у', 'v' => 'в', 'z' => 'з',
        ];

        return strtr($string, $singleCharMap);
    }
}
