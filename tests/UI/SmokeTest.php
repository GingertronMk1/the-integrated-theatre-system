<?php

declare(strict_types=1);

namespace Tests\UI;

use Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group ui
 */
final class SmokeTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @test
     * @dataProvider urlDataProvider
     */
    public function can_view_pages(string $url): void
    {
        $this->client->request('GET', $url);
        $this->assertResponseIsSuccessful();
    }

    public function urlDataProvider(): Generator
    {
        $pages = [
            '/training-category',
            '/training-item'
        ];
        foreach($pages as $page) {
            yield [$page];
        }
    }
    
}
