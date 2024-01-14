<?php

declare(strict_types=1);

namespace Tests\Framework\Controller;

use App\Application\Season\SeasonFixture;
use Tests\Tests\UserInterfaceTestCase;

/**
 * @group userinterface
 */
final class SeasonControllerTest extends UserInterfaceTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures(SeasonFixture::class);
    }

    /**
     * @test
     */
    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', '/season');
        $this->assertResponseIsSuccessful();
        $seasonId = SeasonFixture::inHouseSeason()->id;
        $this->assertSelectorExists("[data-season-id='{$seasonId}']");
    }

    /**
     * @test
     */
    public function testCreate(): void
    {
        $crawler = $this->client->request('GET', '/season/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=season]');
        $newName = 'The name of yet another season';
        $newColour = '#069420';
        $form = $crawler->filter('form[name=season]')->form([
          'season[name]' => $newName,
          'season[colour]' => $newColour,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/season', $crawler->getUri());
        $this->assertSelectorTextContains('table#seasons', $newName);
    }

    /**
     * @test
     */
    public function testUpdate(): void
    {
        $seasonId = SeasonFixture::inHouseSeason()->id;
        $crawler = $this->client->request('GET', "/season/{$seasonId}/update");
        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith("/season/{$seasonId}/update", $crawler->getUri());
        $this->assertSelectorExists('form[name=season]');
        $newName = 'This should have updated';
        $form = $crawler->filter('form[name=season]')->form([
          'season[name]' => $newName,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/season', $crawler->getUri());
        $this->assertSelectorExists("[data-season-id='{$seasonId}']");
        $this->assertSelectorTextContains("[data-season-id='{$seasonId}']", $newName);
    }
}
