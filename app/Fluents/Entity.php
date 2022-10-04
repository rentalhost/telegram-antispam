<?php

declare(strict_types = 1);

namespace Rentalhost\TelegramAntispam\Fluents;

use Illuminate\Support\Fluent;

/**
 * @property int    $offset
 * @property int    $length
 * @property string $type
 */
class Entity
    extends Fluent
{
    public function getText(string $text): string|null
    {
        return mb_substr($text, $this->offset, $this->length);
    }

    public function isUrl(): bool
    {
        return $this->type === 'url';
    }
}
