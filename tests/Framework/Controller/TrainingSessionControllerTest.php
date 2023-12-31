<?php

declare(strict_types=1);

namespace Tests\Framework\Controller;

use App\Application\TrainingSession\TrainingSessionFixture;
use Tests\Tests\UserInterfaceTest;

/**
 * @group userinterface
 */
final class TrainingSessionControllerTest extends UserInterfaceTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures(TrainingSessionFixture::class);
    }

    /**
     * @test
     */
    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', '/training-session');
        $this->assertResponseIsSuccessful();
        $sessionId = TrainingSessionFixture::getTestSession1()->id;
        $this->assertSelectorExists("[data-session-id='{$sessionId}']");
    }

    /**
     * @test
     */
    public function testCreate(): void
    {
        $crawler = $this->client->request('GET', '/training-session/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=training_session]');
        $newName = 'Second test session';
        $form = $crawler->filter('form[name=training_session]')->form([
          'training_session[name]' => $newName,
          'training_session[trainingCategoryId]' => 0,
          'training_session[isDangerous]' => 1,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/training-session', $crawler->getUri());
        $this->assertSelectorTextContains('table#training-sessions', $newName);
    }

    /**
     * @test
     */
    public function testUpdate(): void
    {
        $sessionId = TrainingSessionFixture::getTestSession1()->id;
        $crawler = $this->client->request('GET', "/training-session/update/{$sessionId}");
        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith("/training-session/update/{$sessionId}", $crawler->getUri());
        $this->assertSelectorExists('form[name=training_session]');
        $newName = 'This should have updated';
        $form = $crawler->filter('form[name=training_session]')->form([
          'training_session[name]' => $newName,
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/training-session', $crawler->getUri());
        $this->assertSelectorExists("[data-session-id='{$sessionId}']");
        $this->assertSelectorTextContains("[data-session-id='{$sessionId}']", $newName);
    }
}
