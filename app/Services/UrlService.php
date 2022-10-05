<?php

declare(strict_types = 1);

namespace Rentalhost\TelegramAntispam\Services;

class UrlService
{
    private static function normalizeUrl(string $url): string
    {
        return strtolower(preg_replace('/^www./', '', parse_url($url, PHP_URL_HOST) ?? $url));
    }

    public static function isDomainAllowed(string $url): bool
    {
        return in_array(
            self::normalizeUrl($url),
            config('antispam.allowedDomains')
        );
    }
}
