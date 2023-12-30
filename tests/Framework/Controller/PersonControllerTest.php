<?php

declare(strict_types=1);

namespace Tests\Framework\Controller;

use App\Application\Person\PersonFixture;
use Tests\Tests\UserInterfaceTest;

/**
 * @group userinterface
 */
final class PersonControllerTest extends UserInterfaceTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures(PersonFixture::class);
    }

    /**
     * @test
     */
    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', '/person');
        $this->assertResponseIsSuccessful();
        $personId = PersonFixture::testPerson1()->id;
        $this->assertSelectorExists("[data-person-id='{$personId}']");
    }

    /**
     * @test
     */
    public function testCreate(): void
    {
        $crawler = $this->client->request('GET', '/person/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=person]');
        $newName = 'Second test person';
        $newBio = 'This is a test bio';
        $form = $crawler->filter('form[name=person]')->form([
          'person[name]' => $newName,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith('/person', $crawler->getUri());
        $this->assertSelectorTextContains('table#people', $newName);
    }

    /**
     * @test
     */
    public function testUpdate(): void
    {
        $person = PersonFixture::testPerson1();
        $crawler = $this->client->request('GET', "/person/update/{$person->id}");
        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith("/person/update/{$person->id}", $crawler->getUri());
        $this->assertSelectorExists('form[name=person]');
        $newName = 'This should have updated';
        $form = $crawler->filter('form[name=person]')->form([
          'person[name]' => $newName,
          'person[bio]' => $person->bio,
          'person[startYear]' => $person->startYear,
          'person[endYear]' => $person->endYear,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith('/person', $crawler->getUri());
        $this->assertSelectorExists("[data-person-id='{$person->id}']");
        $this->assertSelectorTextContains("[data-person-id='{$person->id}']", $newName);
    }
}
