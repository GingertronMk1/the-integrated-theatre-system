<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use InvalidArgumentException;
use Stringable;

final readonly class Colour implements Stringable
{
    private function __construct(
        private string $colour
    ) {}

    public static function fromString(string $colour): self
    {
        if (preg_match('/^#[0-9a-zA-Z]{3}$/', $colour)) {
            $splitStr = array_values(str_split($colour));
            $hash = array_shift($splitStr);
            $amendedColour = implode(
                '',
                array_map(
                    fn (string $subStr) => $subStr . '0',
                    $splitStr
                )
            );
            return new self("#{$amendedColour}");
        } else if (preg_match('/^#[0-9a-zA-Z]{6}$/', $colour)) {
            return new self($colour);
        } else {
            throw new InvalidArgumentException("Invalid hex colour string {$colour}");
        }
    }

    public function __toString(): string
    {
        return $this->colour;
    }
}
