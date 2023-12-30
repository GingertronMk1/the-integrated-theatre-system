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
        $this->assertSelectorExists("[data-item-id='{$itemId}']");
    }

    /**
     * @test
     */
    public function testCreate(): void
    {
        $crawler = $this->client->request('GET', '/training-item/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=training_item]');
        $newName = 'Second test item';
        $form = $crawler->filter('form[name=training_item]')->form([
          'training_item[name]' => $newName,
          'training_item[trainingCategoryId]' => 0,
          'training_item[isDangerous]' => 1,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/training-item', $crawler->getUri());
        $this->assertSelectorTextContains('table#training-items', $newName);
    }

    /**
     * @test
     */
    public function testUpdate(): void
    {
        $itemId = TrainingItemFixture::IDS[1];
        $crawler = $this->client->request('GET', "/training-item/update/{$itemId}");
        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith("/training-item/update/{$itemId}", $crawler->getUri());
        $this->assertSelectorExists('form[name=training_item]');
        $newName = 'This should have updated';
        $form = $crawler->filter('form[name=training_item]')->form([
          'training_item[name]' => $newName,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/training-item', $crawler->getUri());
        $this->assertSelectorExists("[data-item-id='{$itemId}']");
        $this->assertSelectorTextContains("[data-item-id='{$itemId}']", $newName);
    }
}
