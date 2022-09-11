<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

  use RefreshDatabase;

  private User $user;

  function setUp(): void
  {
    parent::setUp();
    $this->user = $this->createUser();
  }

  private function createUser()
  {
    return User::factory()->create();
  }

  public function test_new_user_appear_after_login()
  {

    $hasUser = $this->user ? true : false;

    $response = $this->actingAs($this->user)->get('/login');
    $isLogin = false;
    if ($this->user->id == auth()->user()->id) {
      $isLogin = true;
    }
    $this->assertTrue($hasUser);
    $this->assertTrue($isLogin);
    $response->assertRedirect('/');
  }

  public function test_user_can_login_with_correct_credentials()
  {
    $user = User::factory()->create([
      'password' => bcrypt($password = 'i-love-laravel'),
    ]);

    $response = $this->post('/login', [
      'email' => $user->email,
      'password' => $password,
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
  }

  public function test_user_cannot_login_with_incorrect_password()
  {
    $user = User::factory()->create([
      'password' => bcrypt('i-love-laravel'),
    ]);

    $response = $this->from('/login')->post('/login', [
      'email' => $user->email,
      'password' => 'invalid-password',
    ]);

    $response->assertRedirect('/login');
    $response->assertSessionHasErrors('email');
    $this->assertTrue(session()->hasOldInput('email'));
    $this->assertFalse(session()->hasOldInput('password'));
    $this->assertGuest();
  }

  public function test_usuario_no_autorizado_acceda_a_mis_post()
  {
    $response = $this->get('/posts/misposts/1');
    $response->assertStatus(302);
    $response->assertRedirect('login');
  }

  public function test_usuario_no_autorizado_acceda_a_mis_categorias()
  {
    $response = $this->get('/posts/misposts/2');
    $response->assertStatus(302);
    $response->assertRedirect('login');
  }

  public function test_usuario_no_autorizado_acceda_a_mis_etiquetas()
  {
    $response = $this->get('/posts/misposts/3');
    $response->assertStatus(302);
    $response->assertRedirect('login');
  }

  public function test_usuario_no_autorizado_acceda_a_mis_autores()
  {
    $response = $this->get('/posts/misposts/4');
    $response->assertStatus(302);
    $response->assertRedirect('login');
  }

  public function test_usuario_no_autorizado_acceda_a_proximos()
  {
    $response = $this->get('/posts/misposts/5');
    $response->assertStatus(302);
    $response->assertRedirect('login');
  }
}
