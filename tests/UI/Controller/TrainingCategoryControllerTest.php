<?php

declare(strict_types=1);

namespace Tests\UI\Controller;

use App\Application\Fixtures\TrainingCategoryFixture;
use Tests\UI\Common\UserInterfaceTest;

/**
 * @group ui
 */
final class TrainingCategoryControllerTest extends UserInterfaceTest
{
    public function setUp(): void
    {
        self::bootKernel();
        $fixture = self::getContainer()->get(TrainingCategoryFixture::class);
        $fixture->load();
    }

    /**
     * @test
     */
    public function doesCategoryExist(): void
    {
        $expectedId = '018cab99-f343-7faa-9bf4-1f43cadb86c5';
        $crawler = $this->client->request('GET', '/training-category');
        $this->assertSelectorExists("tr[data-category-id={$expectedId}");
    }

    /**
     * @test
     */
    public function testCanCreateCategory(): void
    {
        $testCategoryName = 'Test Category n';
        $crawler = $this->client->request('GET', '/training-category/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=training_category]');
        $form = $crawler->filter('form[name=training_category]')->form([
            'training_category[name]' => $testCategoryName,
        ]);

        $crawler = $this->client->submit($form);

        $this->assertResponseRedirects();

        // Check we have been redirected back to the listing (ie submission was successful)
        // $this->assertStringEndsWith('/training-category', $crawler->getUri());

        // Check the new organisation is listed in the table
        // $this->assertSelectorTextContains('#training-categories', $testCategoryName);
    }
}
