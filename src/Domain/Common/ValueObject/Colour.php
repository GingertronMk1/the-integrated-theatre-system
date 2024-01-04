<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use InvalidArgumentException;
use Stringable;

final readonly class Colour implements Stringable
{
    private function __construct(
        private string $colour
    ) {
    }

    public static function fromString(string $colour): self
    {
        if (preg_match('/^#[0-9a-zA-Z]{3}$/', $colour)) {
            $splitStr = array_values(str_split($colour));
            array_shift($splitStr);
            $amendedColour = implode(
                '',
                array_map(
                    fn (string $subStr) => $subStr.'0',
                    $splitStr
                )
            );

            return new self("#{$amendedColour}");
        } elseif (preg_match('/^#[0-9a-zA-Z]{6}$/', $colour)) {
            return new self($colour);
        } else {
            throw new InvalidArgumentException("Invalid hex colour string {$colour}");
        }
    }

    public static function fromRGB(int $r, int $g, int $b): self
    {
        $hexR = self::intToHex($r);
        $hexG = self::intToHex($g);
        $hexB = self::intToHex($b);

        return self::fromString("#{$hexR}{$hexG}{$hexB}");
    }

    private static function intToHex(int $n): string
    {
        if (256 < $n) {
            throw new InvalidArgumentException("{$n} is too large to be a valid colour");
        }
        if (-1 > $n) {
            throw new InvalidArgumentException("{$n} is too small to be a valid colour");
        }

        return dechex($n);
    }

    public function __toString(): string
    {
        return $this->colour;
    }
}
