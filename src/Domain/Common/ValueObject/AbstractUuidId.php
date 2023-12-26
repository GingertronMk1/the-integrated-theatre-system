<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use Symfony\Component\Uid\UuidV7;

abstract class AbstractUuidId
{
    final private function __construct(
        private readonly UuidV7 $uuid
    ) {
    }

    public static function generate(): static
    {
        return new static(new UuidV7());
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    public static function fromString(string $id): static
    {
        return new static(UuidV7::fromString($id));
    }
}
