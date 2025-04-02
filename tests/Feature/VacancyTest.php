<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Vacancy;

class VacancyTest extends TestCase
{
    #[Test]
    public function employer_can_create_vacancy(): void
    {
        $user = User::factory()->create();

        $user->assignRole('Employer');

        Sanctum::actingAs(
            $user,
            ['*']
        );        

        $vacancy = Vacancy::factory()->create([
            'employer_id' => auth()->id()
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
