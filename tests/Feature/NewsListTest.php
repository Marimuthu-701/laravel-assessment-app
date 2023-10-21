<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class NewsListTest extends TestCase
{
    /**
     * Testing for newslist without authorization
     */
    public function testWithoutAuthorization()
    {
        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('GET', 'api/news', ['Accept' => 'application/json'])
             ->assertStatus(401)
             ->assertJson([
                "message"=> "Unauthenticated."
            ]);
    }

    /**
     * Testing for with Authorization case
     */
    public function testWithAuthorizationNews()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $token = $user->accessToken('api-token');
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'x-api-key'  => env('API_SECRET_KEY')
        ])->json('GET', 'api/news', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "data"=>[
                    "current_page",
                    "data"=> [
                        [
                            "id",
                            "author",
                            "title",
                            "description",
                            "content",
                            "url",
                            "url_to_image",
                            "published_at",
                            "created_at",
                            "updated_at"
                        ]
                    ]
                ],
                "message"
            ]);
    }
}
