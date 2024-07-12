<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpKernel\HttpClientKernel;
use Symfony\Component\HttpKernel\HttpKernelBrowser;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected User $user;

    protected HttpKernelBrowser $browser;

    protected function afterRefreshingDatabase()
    {
        $this->artisan('db:seed');
        $this->user = User::factory()->create();
        $this->browser = new HttpKernelBrowser(new HttpClientKernel());
    }

    protected function getGenericForm(Crawler $crawler, string $formClass): Form
    {
        $selector = "//form[@data-form-class='{$formClass}']";

        return $crawler
            ->filterXPath($selector)
            ->form()
        ;
    }

    protected function getResponseForForm(TestResponse $response, string $formClass, array $values): TestResponse
    {
        $selector = "//form[@data-form-class='{$formClass}']";
        $crawler = new Crawler($response->baseResponse->getContent());
        $form = $crawler
            ->filterXPath($selector)
            ->form()
        ;
        $form->setValues([
            'name' => 'Test Venu',
            'location' => 'Test place',
            'location_additional' => fake()->paragraphs(3, true),
            'capacity' => 500,
        ]);

        return $this->post($form->getUri(), $form->getValues());
    }
}
