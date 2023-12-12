<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Word;
use App\Models\Tag;

class WordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        // $this->withoutExceptionHandling();

        // $word = Word::factory()->make();

        // $response = $this->post('/words', $word->toArray());

        // $response->assertRedirect('dashboard');
        // $this->assertDatabaseHas('words', $word->toArray());
    }
}
