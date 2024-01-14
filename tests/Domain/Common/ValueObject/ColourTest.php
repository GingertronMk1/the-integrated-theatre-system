<?php

declare(strict_types=1);

namespace Tests\Domain\Common\ValueObject;

use App\Domain\Common\ValueObject\Colour;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group domain
 */
final class ColourTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider hexColourDataProvider
     */
    public function testConstructor(string $input, string $expected): void
    {
        $colour = Colour::fromString($input);
        $this->assertEquals($expected, (string) $colour);
    }

    public static function hexColourDataProvider(): array
    {
        return [
            [
                '#faf',
                '#f0a0f0',
            ],
            [
                '#abcdef',
                '#abcdef',
            ],
        ];
    }

    /**
     * @test
     */
    public function throwsExceptionOnInvalidString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $colour = Colour::fromString('blue');
    }

    /**
     * @test
     *
     * @dataProvider rgbColourDataProvider
     */
    public function testRGBInput(int $r, int $g, int $b, string $expected): void
    {
        $colour = Colour::fromRGB($r, $g, $b);
        $this->assertEquals($expected, (string) $colour);
    }

    public static function rgbColourDataProvider(): array
    {
        return [
            [0, 0, 0, '#000000'],
            [255, 255, 255, '#ffffff'],
            [255, 0, 0, '#ff0000'],
            [0, 255, 0, '#00ff00'],
            [0, 0, 255, '#0000ff'],
            [255, 255, 0, '#ffff00'],
            [0, 255, 255, '#00ffff'],
            [255, 0, 255, '#ff00ff'],
            [192, 192, 192, '#c0c0c0'],
            [128, 128, 128, '#808080'],
            [128, 0, 0, '#800000'],
            [128, 128, 0, '#808000'],
            [0, 128, 0, '#008000'],
            [128, 0, 128, '#800080'],
            [0, 128, 128, '#008080'],
            [0, 0, 128, '#000080'],
        ];
    }

    /**
     * @test
     *
     * @dataProvider exceptionRGBProvider
     */
    public function throwsExceptionOnInvalidRGB(int $r, int $g, int $b): void
    {
        $this->expectException(InvalidArgumentException::class);
        $colour = Colour::fromRGB($r, $g, $b);
    }

    public static function exceptionRGBProvider(): array
    {
        return [
            [-1, 0, 0],
            [0, -1, 0],
            [0, 0, -1],
            [256, 0, 0],
            [0, 256, 0],
            [0, 0, 256],
        ];
    }
}
