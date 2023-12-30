<?php

declare(strict_types=1);

namespace Tests\Framework\Controller;

use App\Application\TrainingCategory\TrainingCategoryFixture;
use Tests\Tests\UserInterfaceTest;

/**
 * @group userinterface
 */
final class TrainingCategoryControllerTest extends UserInterfaceTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures(TrainingCategoryFixture::class);
    }

    /**
     * @test
     */
    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', '/training-category');
        $this->assertResponseIsSuccessful();
        $categoryId = TrainingCategoryFixture::IDS[1];
        $this->assertSelectorExists("[data-category-id='{$categoryId}']");
    }
}
