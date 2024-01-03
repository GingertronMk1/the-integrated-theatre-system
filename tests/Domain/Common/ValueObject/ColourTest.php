<?php

declare(strict_types=1);

namespace Tests\Domain\Common\ValueObject;

use PHPUnit\Framework\TestCase;
use App\Domain\Common\ValueObject\Colour;
use InvalidArgumentException;

/**
 * @group domain
 */
final class ColourTest extends TestCase
{
    /**
     * @test
     * @dataProvider colourDataProvider
     */
    public function testConstructor(string $input, string $expected): void
    {
        $colour = Colour::fromString($input);
        $this->assertEquals($expected, (string) $colour);
    }

    public function colourDataProvider(): array
    {
        return [
            [
                '#faf',
                '#f0a0f0'
            ],
            [
                '#abcdef',
                '#abcdef'
            ]
        ];
    }

    /**
     * @test
     */
    public function throwsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $colour = Colour::fromString('blue');
    }
}
