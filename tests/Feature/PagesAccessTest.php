<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class PagesAccessTest extends TestCase
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

  public function test_acceso_guest_a_la_pagina_principal()
  {
    $response = $this->get('/');

    $response->assertStatus(200);
  }
  public function test_guest_en_la_pagina_principal_tiene_login()
  {
    $response = $this->get('/');

    $response->assertSee('Ingresar');
  }
  public function test_guest_en_la_pagina_principal_tiene_registrar()
  {
    $response = $this->get('/');

    $response->assertSee('Registrar');
  }

  public function test_usuario_no_registrado_no_ve_opcion_mis_post()
  {
    $response = $this->get('/');
    $response->assertDontSee('Mis posts');
  }
  public function test_usuario_no_registrado_no_ve_opcion_mis_categorias()
  {
    $response = $this->get('/');
    $response->assertDontSee('Mis categorias');
  }
  public function test_usuario_no_registrado_no_ve_opcion_mis_etiquetas()
  {
    $response = $this->get('/');
    $response->assertDontSee('Mis etiquetas');
  }
  public function test_usuario_no_registrado_no_ve_opcion_mis_autores()
  {
    $response = $this->get('/');
    $response->assertDontSee('Mis autores');
  }
  public function test_usuario_no_registrado_no_ve_opcion_proximos()
  {
    $response = $this->get('/');
    $response->assertDontSee('Próximos');
  }

  public function test_usuario_registrado_tiene_opcion_mis_post()
  {
    $response = $this->post('/login', [
      'email' => $this->user->email,
      'password' => $this->user->password,
    ]);
    $response = $this->actingAs($this->user)->get('/');
    $response->assertSee('Mis posts');
  }
  public function test_usuario_registrado_tiene_opcion_mis_categorias()
  {
    $response = $this->post('/login', [
      'email' => $this->user->email,
      'password' => $this->user->password,
    ]);
    $response = $this->actingAs($this->user)->get('/');
    $response->assertSee('Mis categorias');
  }
  public function test_usuario_registrado_tiene_opcion_mis_etiquetas()
  {
    $response = $this->post('/login', [
      'email' => $this->user->email,
      'password' => $this->user->password,
    ]);
    $response = $this->actingAs($this->user)->get('/');
    $response->assertSee('Mis etiquetas');
  }
  public function test_usuario_registrado_tiene_opcion_mis_autores()
  {
    $response = $this->post('/login', [
      'email' => $this->user->email,
      'password' => $this->user->password,
    ]);
    $response = $this->actingAs($this->user)->get('/');
    $response->assertSee('Mis autores');
  }
  public function test_usuario_registrado_tiene_opcion_proximos()
  {
    $response = $this->post('/login', [
      'email' => $this->user->email,
      'password' => $this->user->password,
    ]);
    $response = $this->actingAs($this->user)->get('/');
    $response->assertSee('Próximos');
  }

  public function test_acceso_usuario_registrado_a_la_pagina_mis_post()
  {
    $hasUser = $this->user ? true : false;

    $this->assertTrue($hasUser);

    $response = $this->actingAs($this->user)->get('/posts/misposts/1');
    $response->assertStatus(200);
  }
  public function test_acceso_usuario_registrado_a_la_pagina_mis_categorias()
  {
    $hasUser = $this->user ? true : false;

    $this->assertTrue($hasUser);

    $response = $this->actingAs($this->user)->get('/posts/misposts/2');
    $response->assertStatus(200);
  }

  public function test_acceso_usuario_registrado_a_la_pagina_mis_etiquetas()
  {
    $hasUser = $this->user ? true : false;

    $this->assertTrue($hasUser);

    $response = $this->actingAs($this->user)->get('/posts/misposts/3');
    $response->assertStatus(200);
  }

  public function test_acceso_usuario_registrado_a_la_pagina_mis_autores()
  {
    $hasUser = $this->user ? true : false;

    $this->assertTrue($hasUser);

    $response = $this->actingAs($this->user)->get('/posts/misposts/4');

    $response->assertStatus(200);
  }

  public function test_acceso_usuario_registrado_a_la_pagina_proximos_posts()
  {
    $hasUser = $this->user ? true : false;

    $this->assertTrue($hasUser);

    $response = $this->actingAs($this->user)->get('/posts/misposts/5');

    $response->assertStatus(200);
  }

  public function test_acceso_guest_a_la_pagina_login()
  {
    $response = $this->get('/login');

    $response->assertStatus(200);
  }

  public function test_acceso_guest_a_la_pagina_registro()
  {
    $response = $this->get('/register');

    $response->assertStatus(200);
  }
}
