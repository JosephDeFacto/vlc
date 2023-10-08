<?php

namespace Tests\Feature;

use App\Service\ApiService;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /**
     * Test a valid search query with results.
     */
    public function testValidSearchQuery(): void
    {
        $query = 'deadwood';

        $this->mock(ApiService::class)
            ->shouldReceive('makeRequest')
            ->with($query)
            ->once()
            ->andReturn([
                ['show' => ['name' => 'Deadwood']],
            ]);

        $response = $this->get("search?q={$query}");

        $response->assertStatus(200)
            ->assertSee('Deadwood');
    }

    /**
     * Test missing search query.
     */
    public function testMissingSearchQuery(): void
    {
        $query = '';


        $this->partialMock(ApiService::class, function ($mock) use ($query) {
            $mock->shouldReceive('makeRequest')
                ->with($query)
                ->andReturn([]);
        });

        $response = $this->get("search?q={$query}");

        $response->assertStatus(400)
            ->assertSee('Your input field is empty');
    }

    /**
     * Test a valid search query with no results.
     */
    public function testValidSearchQueryWithNoResults(): void
    {
        $query = 'nonexistent';

        $this->partialMock(ApiService::class, function ($mock) use ($query) {
            $mock->shouldReceive('makeRequest')
                ->with($query)
                ->andReturn([]);
        });

        $response = $this->get("search?q={$query}");

        $response->assertStatus(404)
            ->assertSee(['No results found']);
    }
}
