<?php

declare(strict_types = 1);

namespace Rentalhost\TelegramAntispam\Fluents;

use Illuminate\Support\Fluent;

/**
 * @property int            $offset
 * @property int            $length
 * @property string         $type
 * @property array{id: int} $user
 * @property string         $url
 */
class Entity
    extends Fluent
{
    public function getText(string $text): string
    {
        return mb_substr($text, $this->offset, $this->length);
    }

    public function getUserId(): int|null
    {
        return $this->user['id'] ?? null;
    }

    public function isTextLink(): bool
    {
        return $this->type === 'text_link';
    }

    public function isTextMention(): bool
    {
        return $this->type === 'text_mention';
    }

    public function isUrl(): bool
    {
        return $this->type === 'url';
    }
}
