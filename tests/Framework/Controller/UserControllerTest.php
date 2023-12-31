<?php

declare(strict_types=1);

namespace Tests\Framework\Controller;

use App\Application\User\UserFinderInterface;
use App\Application\User\UserFixture;
use App\Application\User\UserModel;
use Tests\Tests\UserInterfaceTest;

final class UserControllerTest extends UserInterfaceTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures(UserFixture::class);
    }

    /**
     * @test
     */
    public function testCreate(): void
    {
        $crawler = $this->client->request('GET', '/user/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=user]');
        $email = 'testemail@tits.org';
        $form = $crawler->filter('form[name=user]')->form([
          'user[email]' => $email,
          'user[password]' => '12345',
        ]);
        $crawler = $this->client->submit($form);
        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith('/', $crawler->getUri());

        $userFinder = self::getContainer()->get(UserFinderInterface::class);
        $allUserEmails = array_map(
            fn (UserModel $user) => $user->email,
            $userFinder->findAll()
        );
        $this->assertContains($email, $allUserEmails);
    }
}
