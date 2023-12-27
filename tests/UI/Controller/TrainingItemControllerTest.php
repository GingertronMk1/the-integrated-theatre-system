<?php

declare(strict_types=1);

namespace Tests\UI\Controller;

use App\Application\Fixtures\TrainingItemFixture;
use Tests\UI\Common\UserInterfaceTest;

/**
 * @group ui
 */
final class TrainingItemControllerTest extends UserInterfaceTest
{
    protected array $fixtureClasses = [TrainingItemFixture::class];

    /**
     * @test
     */
    public function doesItemExist(): void
    {
        $expectedId = '018cace9-edc1-74bf-bc8f-582b4a68a3ac';
        $crawler = $this->client->request('GET', '/training-item');
        $this->assertSelectorExists("tr[data-item-id='{$expectedId}']");
    }

    /**
     * @test
     */
    public function testCanCreateItem(): void
    {
        $testItemName = 'Test Item n';
        $crawler = $this->client->request('GET', '/training-item/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=training_item]');
        $form = $crawler->filter('form[name=training_item]')->form([
            'training_item[name]' => $testItemName,
        ]);

        $crawler = $this->client->submit($form);

        // Check we have been redirected back to the listing (ie submission was successful)
        $this->assertStringEndsWith('/training-item', $crawler->getUri());

        // Check the new organisation is listed in the table
        $this->assertSelectorTextContains('#training-categories', $testItemName);
    }

    /**
     * @test
     */
    public function testCanUpdateItem(): void
    {
        $expectedId = '018cab99-f343-7faa-9bf4-1f43cadb86c5';
        $testItemName = 'This should have changed';
        $crawler = $this->client->request('GET', "/training-item/update/{$expectedId}");
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=training_item]');
        $form = $crawler->filter('form[name=training_item]')->form([
            'training_item[name]' => $testItemName,
        ]);

        $crawler = $this->client->submit($form);

        // Check we have been redirected back to the listing (ie submission was successful)
        $this->assertStringEndsWith('/training-item', $crawler->getUri());

        $this->assertSelectorExists("tr[data-item-id='{$expectedId}']");
        // Check the new organisation is listed in the table
        $this->assertSelectorTextContains("tr[data-item-id='{$expectedId}']", $testItemName);
    }
}
