<?php

declare(strict_types=1);

namespace Tests\Domain\Common\ValueObject;

use App\Domain\Common\ValueObject\AbstractUuidId;
use App\Domain\User\ValueObject\UserId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group domain
 */
final class UserIdTest extends TestCase
{
    /**
     * @test
     */
    public function can_access_string_as_expected(): void {
        $id = UserId::fromString('018c9c37-6586-7da2-95de-8e86bd69a1fb');
        $this->assertEquals('018c9c37-6586-7da2-95de-8e86bd69a1fb', (string) $id);
    }

    /**
     * @test
     */
    public function will_generate_unique_identifiers(): void {
        $id1 = UserId::generate();
        $id2 = UserId::generate();
        $this->assertNotEquals((string) $id1, (string) $id2);
    }

    /**
     * @test
     */
    public function has_to_be_well_formed_uuid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $id = UserId::fromString('This will not work');
    }
}
