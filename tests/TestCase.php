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
            $formValues = $form->getValues();
            foreach ($expectedCurrentValues as $key => $value) {
                $this->assertEquals(
                    $value,
                    $formValues[$key],
                );
            }
        }

        $form->setValues($values);

        return $this->post($form->getUri(), $form->getValues());
    }
}
