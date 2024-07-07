<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Person;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;

class PersonControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_is_behind_auth_wall(): void
    {
        $response = $this->get(route('person.index'));
        $response->assertRedirect();
    }

    public function test_index_contains_people(): void
    {
        $response = $this->actingAs($this->user)->get(route('person.index'));
        $response->assertSeeInOrder(Person::all()->pluck('id')->toArray());
    }

    public function test_create_shows_form(): void
    {
        $response = $this->actingAs($this->user)->get(route('person.create'));
        $response->assertOk();
        foreach ([
            'input[name=name]',
            'input[name=start_year]',
            'input[name=end_year]',
        ] as $input) {
            $crawler = new Crawler($response->baseResponse->content());
            $crawler->filter($input);
            $this->assertGreaterThan(0, $crawler->count());
        }
    }

    public function test_edit_shows_form(): void
    {
        $person = Person::factory()->create();
        $response = $this->actingAs($this->user)->get(route('person.edit', ['person' => $person]));
        $response->assertOk();
        foreach ([
            'input[name=name]',
            'input[name=start_year]',
            'input[name=end_year]',
        ] as $input) {
            $crawler = new Crawler($response->baseResponse->content());
            $crawler->filter($input);
            $this->assertGreaterThan(0, $crawler->count());
        }

    }

    public function test_show(): void
    {
        $person = Person::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->get(route('person.show', ['person' => $person]));
        $response->assertOk();
    }

    public function test_store_creates_properly(): void
    {
        $name = 'PHPUnit Jones';
        $startYear = 1997;
        $endYear = 2015;

        $response = $this
            ->actingAs($this->user)
            ->post(route('person.store'), [
                'name' => $name,
                'start_year' => $startYear,
                'end_year' => $endYear,
            ]);
        $response->assertRedirectToRoute('person.index');

        $person = Person::firstWhere('name', $name);
        $this->assertNotNull($person);
        $this->assertEquals($name, $person->name);
        $this->assertEquals($startYear, $person->start_year);
        $this->assertEquals($endYear, $person->end_year);
    }

    public function test_update_updates_properly(): void
    {
        $person = Person::factory()->create();
        $name = 'PHPUnit Jones';
        $startYear = 1997;
        $endYear = 2015;

        $response = $this
            ->actingAs($this->user)
            ->put(route('person.update', ['person' => $person]), [
                'name' => $name,
                'start_year' => $startYear,
                'end_year' => $endYear,
            ]);
        $response->assertRedirectToRoute('person.index');

        $person->refresh();
        $this->assertNotNull($person);
        $this->assertEquals($name, $person->name);
        $this->assertEquals($startYear, $person->start_year);
        $this->assertEquals($endYear, $person->end_year);
    }

    public function test_delete_sets_delete(): void
    {
        $person = Person::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('person.destroy', ['person' => $person]));
        $response->assertRedirect();
        $person->refresh();
        $this->assertNotNull($person->deleted_at);
    }
}
