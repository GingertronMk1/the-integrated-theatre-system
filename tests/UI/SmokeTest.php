<?php

declare(strict_types=1);

namespace Tests\UI;

use Generator;
use Tests\UI\Common\UserInterfaceTest;

/**
 * @group ui
 */
final class SmokeTest extends UserInterfaceTest
{
    /**
     * @test
     *
     * @dataProvider urlDataProvider
     */
    public function canViewPages(string $url): void
    {
        $this->client->request('GET', $url);
        $this->assertResponseIsSuccessful();
    }

    public function urlDataProvider(): Generator
    {
        $pages = [
            '/',
            '/training-category',
            '/training-item',
        ];
        foreach ($pages as $page) {
            yield [$page];
        }
    }
}
