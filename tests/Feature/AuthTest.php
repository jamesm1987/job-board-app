<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Laravel\Sanctum\Sanctum;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->seed();
    }
    
    #[Test]
    public function user_can_register(): void
    {
        $role = Role::whereNot('name', 'Admin')->pluck('name')->random();
        
        $response = $this->postJson('/api/register', [
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => $role
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['user' => 'token']);

        
        $this->assertDatabaseHas('users', [
            'email' => 'user@user.com'
        ]);
    }

    #[Test]
    public function user_cannot_register_with_existing_email(): void
    {

        $role = Role::whereNot('name', 'Admin')->pluck('name')->random();
        $user = User::factory()->create([
            'name' => 'Existing User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole($role);

        $response = $this->postJson('/api/register', [
            'name' => 'New User',
            'email' => 'user@user.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
   
    #[Test]
    public function user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'user@user.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'user@user.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    #[Test]
    public function user_cannot_login_with_unvalid_credentials()
    {

        $response = $this->postJson('/api/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Invalid credentials']);
    }

    #[Test]
    public function user_can_logout()
    {

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson('/api/logout');

    
        $response->assertOk();
    }
}
