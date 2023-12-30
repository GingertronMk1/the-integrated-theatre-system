<?php

declare(strict_types=1);

namespace Tests\Framework\Controller;

use App\Application\TrainingItem\TrainingItemFixture;
use Tests\Tests\TestWithFixturesTrait;
use Tests\Tests\UserInterfaceTest;

/**
 * @group userinterface
 */
final class TrainingItemControllerTest extends UserInterfaceTest
{
    use TestWithFixturesTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures(TrainingItemFixture::class);
    }

    /**
     * @test
     */
    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', '/training-item');
        $this->assertResponseIsSuccessful();
        $itemId = TrainingItemFixture::IDS[1];
        $this->assertSelectorExists('[data-item-id]');
    }
}
