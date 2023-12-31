<?php

declare(strict_types=1);

namespace Tests\Framework\Controller;

use App\Application\Person\PersonFixture;
use App\Application\TrainingItem\TrainingItemFixture;
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
        $item = TrainingItemFixture::getSessionTestFixture();
        $trainer = PersonFixture::testSessionPerson1();
        $trainee = PersonFixture::testSessionPerson2();
        $form = $crawler->filter('form[name=training_session]')->form([
          'training_session[occurredAt]' => '2024-01-01T16:00',
          'training_session[items]' => [(string) $item->id],
          'training_session[trainers]' => [(string) $trainer->id],
          'training_session[trainees]' => [(string) $trainee->id],
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/training-session', $crawler->getUri());
        $this->assertSelectorExists("table#training-sessions li[data-item-id='{$item->id}']");
        $this->assertSelectorTextContains(
            "table#training-sessions li[data-item-id='{$item->id}']",
            $item->name
        );
        $this->assertSelectorExists("table#training-sessions li[data-trainer-id='{$trainer->id}']");
        $this->assertSelectorTextContains(
            "table#training-sessions li[data-trainer-id='{$trainer->id}']",
            $trainer->name
        );
        $this->assertSelectorExists("table#training-sessions li[data-trainee-id='{$trainee->id}']");
        $this->assertSelectorTextContains(
            "table#training-sessions li[data-trainee-id='{$trainee->id}']",
            $trainee->name
        );
    }

    /**
     * @test
     */
    public function testUpdate(): void
    {
        $session = TrainingSessionFixture::getTestSession1();
        $crawler = $this->client->request('GET', "/training-session/update/{$session->id}");
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=training_session]');
        $item = TrainingItemFixture::getSessionTestFixture();
        $trainer = PersonFixture::testSessionPerson2();
        $trainee = PersonFixture::testSessionPerson1();
        $form = $crawler->filter('form[name=training_session]')->form([
          'training_session[occurredAt]' => '2024-01-01T16:00',
          'training_session[items]' => [(string) $item->id],
          'training_session[trainers]' => [(string) $trainer->id],
          'training_session[trainees]' => [(string) $trainee->id],
        ]);
        $crawler = $this->client->submit($form);
        $this->assertStringEndsWith('/training-session', $crawler->getUri());
        $sessionSelector = "table#training-sessions tr[data-session-id='{$session->id}']";
        $this->assertSelectorExists("{$sessionSelector} li[data-item-id='{$item->id}']");
        $this->assertSelectorTextContains(
            "{$sessionSelector} li[data-item-id='{$item->id}']",
            $item->name
        );
        $this->assertSelectorExists("{$sessionSelector} li[data-trainer-id='{$trainer->id}']");
        $this->assertSelectorTextContains(
            "{$sessionSelector} li[data-trainer-id='{$trainer->id}']",
            $trainer->name
        );
        $this->assertSelectorExists("{$sessionSelector} li[data-trainee-id='{$trainee->id}']");
        $this->assertSelectorTextContains(
            "{$sessionSelector} li[data-trainee-id='{$trainee->id}']",
            $trainee->name
        );
    }
}
