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

    public static function generate(): self
    {
        return new static(new UuidV7());
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    public static function fromString(string $id): self
    {
        return new static(UuidV7::fromString($id));
    }
}
