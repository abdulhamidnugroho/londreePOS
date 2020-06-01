<?php

namespace Tests\Feature\Api\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterControllerTest extends TestCase
{
	use WithoutMiddleware, RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
	}

	public function testRegistrationUser()
	{
		$data = [
			'name'  => $this->user->name,
			'email' => 'tony_admin@laravel.it',
			'password' => $this->user->password
		];

		$response = $this->json('POST', route('api.auth.register'), $data)->assertJson([
            'status' => 'success'
        ])->assertStatus(200);
	}
}
