<?php

declare(strict_types=1);

namespace Tests\UI\Controller;

use Tests\UI\Common\UserInterfaceTest;

/**
 * @group ui
 */
final class TrainingCategoryControllerTest extends UserInterfaceTest
{
    /**
     * @test
     */
    public function test_can_create_category(): void
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
