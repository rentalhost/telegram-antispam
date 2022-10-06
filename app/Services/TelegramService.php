<?php

declare(strict_types = 1);

namespace Rentalhost\TelegramAntispam\Services;

class TelegramService
{
    /** @see https://stackoverflow.com/a/66878985/755393 */
    static function substr($text, $offset, $length): string
    {
        $bmp = [];

        for ($i = 0; $i < mb_strlen($text); $i++) {
            $mb_substr = mb_substr($text, $i, 1);
            $mb_ord    = mb_ord($mb_substr);
            $bmp[]     = $mb_substr;

            if ($mb_ord > 0xFFFF) {
                $bmp[] = '';
            }
        }

        return implode('', array_slice($bmp, $offset, $length));
    }
}
