<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use Symfony\Component\DomCrawler\Crawler;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function afterRefreshingDatabase()
    {
        // $this->artisan('db:seed');
        $this->user = User::factory()->create();
    }

    protected function getResponseForForm(
        TestResponse $response,
        string $formClass,
        array $values,
        array $expectedCurrentValues = []
    ): TestResponse {
        $selector = "//form[@data-form-class='{$formClass}']";
        $crawler = new Crawler($response->baseResponse->getContent());

        $form = $crawler
            ->filterXPath($selector)
            ->form()
        ;

        if (!empty($expectedCurrentValues)) {
            $currentValues = $form->getValues();
            foreach ($expectedCurrentValues as $name => $value) {
                $this->assertEquals($value, $currentValues[$name]);
            }
        }

        $form->setValues($values);

        return $this->post($form->getUri(), $form->getValues());
    }
}
