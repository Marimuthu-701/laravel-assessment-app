<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * Testing for login required field
     */
    public function testLoginRequiredField()
    {
        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('POST', 'api/login', ['Accept' => 'application/json'])
             ->assertStatus(422)
             ->assertJson([
                "success"=> false,
                "message"=> "The email field is required., The password field is required."
            ]);
    }


    /**
     * Testing for invalide case
     */
    public function testInvalidLogin()
    {
        $loginCredencial = [
            "email" => "marimuthu.m@oclocksolutions.com",
            "password" => "mari12345",
        ];
        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('POST', 'api/login', $loginCredencial, ['Accept' => 'application/json'])
        ->assertStatus(401)
        ->assertJson([
            "success"=> false,
            "message"=> "Invalid login details"
        ]);
    }

    /**
     * Testing for success case
     */
    public function testLoginSuccess()
    {
        $loginCredencial = [
            "email" => "marimuthu.m@oclocksolutions.com",
            "password" => "muthu123",
        ];
        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('POST', 'api/login', $loginCredencial, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "success",
            "data"=> [
                "id" ,
                "name",
                "email",
                "email_verified_at",
                "created_at",
                "updated_at",
                "token",
            ],
            "message"
        ]);
    }

    /**
     * Testing for user registration required fiels
     */
    public function testUserRegisterRequiredField()
    {
        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('POST', 'api/register', ['Accept' => 'application/json'])
                ->assertStatus(422)
                ->assertJson([
                "success"=> false,
                "message"=> "The name field is required., The email field is required., The password field is required."
            ]);
    }

    /**
     * Testing for email already exists and confirm password miss match
     */
    public function testEmailAlreadyExists()
    {
        $registerData = [
            "name"=>"Marimuthu",
            "email"=>"marimuthu.m@oclocksolutions.com",
            "password"=>"muthu123",
            "password_confirmation"=>"muthu123",
        ];

        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('POST', 'api/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "success"=> false,
                "message"=> "The email has already been taken."
            ]);
    }

    /**
     * Testing for registration confirm password miss match
     */
    public function testRegisterConfirmPasswordMissMatch()
    {
        $registerData = [
            "name"=>fake()->name(),
            "email"=>fake()->unique()->safeEmail(),
            "password"=>"muthu@123",
            "password_confirmation"=>"muthu123",
        ];

        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('POST', 'api/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "success"=> false,
                "message"=> "The password field confirmation does not match."
            ]);
    }

    /**
     * Testing for Registration success
     */
    public function testRegistrationSuccess()
    {
        $registerData = [
            "name"=>fake()->name(),
            "email"=> fake()->unique()->safeEmail(),
            "password"=>"muthu@123",
            "password_confirmation"=>"muthu@123",
        ];

        $this->withHeader('x-api-key', env('API_SECRET_KEY'))->json('POST', 'api/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "success",
                "data"=> [
                    "id" ,
                    "name",
                    "email",
                    "created_at",
                    "updated_at",
                    "token",
                ],
                "message"
            ]);
    }
}
