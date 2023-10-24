<?php

namespace Tests\Feature;

use App\Models\User;
use Hash;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    /**
     * Testing for user data not found
     */
    public function testUserDataNotFound()
    {
        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('PUT', 'api/users/100000/update', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'User not found',
            ]);
    }

    /**
     * Testing for user update required field
     */
    public function testUserUpdateRequiredField()
    {
        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('PUT', 'api/users/1/update', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'The email field is required., The name field is required.',
            ]);
    }

    /**
     * Testing for already exists email
     */
    public function testUserEmailAlreadyExists()
    {
        $userData = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
        ];
        $user = User::create($userData);
        $existing_email = User::first()->email;
        $userDetails = [
            'name' => fake()->name(),
            'email' => $existing_email,
        ];

        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('PUT', 'api/users/'.$user->id.'/update', $userDetails, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'The email has already been taken.',
            ]);
    }

    /**
     * Testing for user update success
     */
    public function testUserUpdateSucess()
    {
        $userDetails = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ];
        $existing_id = User::latest()->first()->id;
        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('PUT', 'api/users/'.$existing_id.'/update', $userDetails, ['Accept' => 'application/json'])
            ->assertStatus(202)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
                'message',
            ]);
    }
}
