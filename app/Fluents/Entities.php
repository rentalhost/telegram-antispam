<?php

declare(strict_types = 1);

namespace Rentalhost\TelegramAntispam\Fluents;

use Illuminate\Support\Collection;

class Entities
    extends Collection
{
    /** @return Entity[] */
    public function getEntities(): array
    {
        return array_map(
            static fn(array $entity) => new Entity($entity),
            $this->toArray()
        );
    }
}
