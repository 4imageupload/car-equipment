<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\VerifyEmail;

class UserTest extends TestCase
{
  use RefreshDatabase;

    /** @test */
    public function user_can_create_new_account()
    {
      $this->withoutExceptionHandling();

      $this->post('/register', [
        'name' => 'Tuan Nguyen',
        'email' => 'tuan.nv.vina@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
      ]);

      $this->assertDatabaseHas('users', [
        'name' => 'Tuan Nguyen',
        'email' => 'tuan.nv.vina@gmail.com',
      ]);

      $this->assertDatabaseCount('verify_emails', 1);
    }


    /** @test */
    public function users_can_verify_their_account_with_link_sent_to_email()
    {
      $this->withoutExceptionHandling();

      //Create one user with factory
      $user = User::factory()->create();

      $token = VerifyEmail::factory()->create([
        'user_id' => $user->id
      ]);

      //Get verify email token
      $mailToken = VerifyEmail::where('user_id', $user->id)->first()->email_token;

      //Asert verify_email_at column at the users table not equal null.
      $this->assertDatabaseHas('users', [
          'email_verified_at' => null
      ]);

      //Send request with email token to server
      $response = $this->get("/verify-email?email_token=$mailToken");

      //Asert verify_email_at column at the users table not equal null.
      $this->assertDatabaseMissing('users', [
          'email_verified_at' => null
      ]);

      $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_log_in()
    {
      $this->withoutExceptionHandling();
      $user = User::factory()->create([
        'email_verified_at' => time()
      ]);

      $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password'
      ]);

      $this->assertTrue(auth()->check());
      $response->assertSee('login');
    }

    /** @test */
    public function user_can_log_out()
    {
      $this->withoutExceptionHandling();

      $user = User::factory()->create([
        'email_verified_at' => time()
      ]);

      auth()->login($user);

      $this->assertTrue(auth()->check());

      $this->get('/log-out');

      $this->assertFalse(auth()->check());
    }


    public function admin_can_create_new_role() {
      //Create new admin role in role table.

      //Create new user with role is admin.

      //Log in user as admin user

      //create new role with post request

      //Assert database has that role.
    }

}
