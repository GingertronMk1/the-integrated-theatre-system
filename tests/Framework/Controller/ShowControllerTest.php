<?php

declare(strict_types=1);

namespace Tests\Framework\Controller;

use App\Application\Show\ShowFixture;
use Tests\Tests\UserInterfaceTest;

/**
 * @group userinterface
 */
final class ShowControllerTest extends UserInterfaceTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures(ShowFixture::class);
    }

    /**
     * @test
     */
    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', '/show');
        $this->assertResponseIsSuccessful();
        $showId = ShowFixture::testShow1()->id;
        $this->assertSelectorExists("[data-show-id='{$showId}']");
    }

    /**
     * @test
     */
    public function testCreate(): void
    {
        $crawler = $this->client->request('GET', '/show/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=show]');
        $newName = 'The name of yet another show';
        $form = $crawler->filter('form[name=show]')->form([
          'show[name]' => $newName,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/show', $crawler->getUri());
        $this->assertSelectorTextContains('table#shows', $newName);
    }

    /**
     * @test
     */
    public function testUpdate(): void
    {
        $showId = ShowFixture::testShow1()->id;
        $crawler = $this->client->request('GET', "/show/{$showId}/update");
        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith("/show/{$showId}/update", $crawler->getUri());
        $this->assertSelectorExists('form[name=show]');
        $newName = 'This should have updated';
        $form = $crawler->filter('form[name=show]')->form([
          'show[name]' => $newName,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/show', $crawler->getUri());
        $this->assertSelectorExists("[data-show-id='{$showId}']");
        $this->assertSelectorTextContains("[data-show-id='{$showId}']", $newName);
    }
}
