<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_upload_to_login(): void
    {
        $this->get('/upload')->assertRedirect('/login');
    }

    public function test_user_can_register_and_login(): void
    {
        $this->post('/cadastro', [
            'name' => 'Usuario Teste',
            'email' => 'usuario@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'email' => 'usuario@example.com',
        ]);

        $this->post('/login', [
            'email' => 'usuario@example.com',
            'password' => 'password',
        ])->assertRedirect('/upload');

        $this->assertAuthenticated();
    }
}
