<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    /*
     * This to test the registration fields that they are all required
     */
    public function testRequiredFieldsForRegistration(): void
    {
        $this->json('POST', 'api/user/create', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    "first_name" => ["The first name field is required."],
                    "last_name" => ["The last name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    public function testRepeatPassword(): void
    {
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'doe@example.com',
            'password' => 'demo12345'
        ];

        $this->json('POST', 'api/user/create', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The password confirmation does not match.",
                "errors" => [
                    "password" => ["The password confirmation does not match."]
                ]
            ]);
    }

    public function testSuccessfulRegistration(): void
    {
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'doe@example.com',
            'password' => 'demo12345',
            'password_confirmation' => 'demo12345'
        ];

        $this->json('POST', 'api/user/create', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'token',
                'errors'
            ]);
    }
}
