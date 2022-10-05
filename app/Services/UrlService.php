<?php

declare(strict_types = 1);

namespace Rentalhost\TelegramAntispam\Services;

class UrlService
{
    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private static function normalizeUrl(string $url): string
    {
        return parse_url('https://' . strtolower(preg_replace('#^(https?://)?(www|m).#', '', $url)), PHP_URL_HOST);
    }

    public static function isDomainAllowed(string $url): bool
    {
        return in_array(
            self::normalizeUrl($url),
            config('antispam.allowedDomains')
        );
    }
}
