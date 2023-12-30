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

    /**
     * @test
     */
    public function testCreate(): void
    {
        $crawler = $this->client->request('GET', '/training-category/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=training_category]');
        $newName = 'Second test category';
        $form = $crawler->filter('form[name=training_category]')->form([
          'training_category[name]' => $newName,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/training-category', $crawler->getUri());
        $this->assertSelectorTextContains('table#training-categories', $newName);
    }

    /**
     * @test
     */
    public function testUpdate(): void
    {
        $categoryId = TrainingCategoryFixture::IDS[1];
        $crawler = $this->client->request('GET', "/training-category/update/{$categoryId}");
        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith("/training-category/update/{$categoryId}", $crawler->getUri());
        $this->assertSelectorExists('form[name=training_category]');
        $newName = 'This should have updated';
        $form = $crawler->filter('form[name=training_category]')->form([
          'training_category[name]' => $newName,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/training-category', $crawler->getUri());
        $this->assertSelectorExists("[data-category-id='{$categoryId}']");
        $this->assertSelectorTextContains("[data-category-id='{$categoryId}']", $newName);
    }
}
