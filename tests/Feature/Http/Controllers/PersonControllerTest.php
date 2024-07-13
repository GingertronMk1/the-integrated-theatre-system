<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Person;
use App\View\Components\Form\PersonForm;
use Tests\TestCase;

class PersonControllerTest extends TestCase
{
    public function testIndexContainsPeople(): void
    {
        $response = $this->actingAs($this->user)->get(route('person.index'));
        $response->assertSeeInOrder(Person::all()->pluck('id')->toArray());
    }

    public function testCreateAndStore(): void
    {
        $response = $this->actingAs($this->user)->get(route('person.create'));
        $response->assertOk();
        $formResponse = $this->getResponseForForm($response, PersonForm::class, [
            'name' => 'Test Person',
            'start_year' => 1997,
            'end_year' => 2019,
        ]);
        $formResponse->assertRedirect();
    }

    public function testEditAndUpdate(): void
    {
        $initialPersonAttributes = [
            'name' => 'Test Name',
            'start_year' => 1997,
            'end_year' => 2019,
        ];
        $person = Person::create($initialPersonAttributes);
        $response = $this
            ->actingAs($this->user)
            ->get(route('person.edit', ['person' => $person]))
        ;
        $response->assertOk();

        $formResponse = $this->getResponseForForm(
            $response,
            PersonForm::class,
            [
                'name' => 'awooga',
            ],
            $initialPersonAttributes
        );
        $formResponse->assertRedirect();
    }

    public function testShow(): void
    {
        $person = Person::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->get(route('person.show', ['person' => $person]))
        ;
        $response->assertOk();
    }

    public function testDeleteSetsDelete(): void
    {
        $person = Person::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('person.destroy', ['person' => $person]));
        $response->assertRedirect();
        $person->refresh();
        $this->assertNotNull($person->deleted_at);
    }
}
