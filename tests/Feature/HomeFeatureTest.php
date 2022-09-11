<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Image;
use App\Models\Post;
use App\Models\State;
use App\Models\Tag;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StateSeeder;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Maize\Markable\Models\Bookmark;
use Maize\Markable\Models\Like;
use Maize\Markable\Models\Reaction;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class HomeFeatureTest extends TestCase
{
  use RefreshDatabase;

  private User $user;
  private User $autor;
  private User $editor;
  private User $publicador;
  private Categoria $categoria;
  private Tag $tag;
  private Post $post;

  public function setUp(): void
  {
    parent::setUp();
    $faker = Factory::create();
    $this->seed(RoleSeeder::class);
    $this->seed(StateSeeder::class);
    $this->categoria = Categoria::factory(1)->create()->first();
    $this->tags = Tag::factory(5)->create();
    $this->user = $this->createUser();
    $this->autor = $this->createUser();
    $this->autor->assignRole(['Autor']);
    $this->editor = $this->createUser();
    $this->editor->assignRole(['Editor']);
    $this->publicador = $this->createUser();
    $this->publicador->assignRole(['Publicador']);

    $this->post = $this->createPost();

    Image::factory(1)->create([
      'imageable_id' => $this->post->id,
      'imageable_type' => Post::class,
    ]);

    Bookmark::add($this->post, $this->user);

    Like::add($this->post, $this->user);
    $react = $faker->randomElement(['thumbup', 'heart', 'star']);
    Reaction::add($this->post, $this->user, $react);
  }

  private function createUser()
  {
    return User::factory()->create();
  }
  private function createPost()
  {

    $faker = Factory::create();
    $name = $faker->unique()->sentence();

    $post = Post::factory()->create([
      'name' => $name,
      'slug' => Str::slug($name),
      'extract' => $faker->text(250),
      'body' => $faker->text(2000),
      'categoria_id' => $this->categoria->id,
      'state_id' => 5,
      'user_id' => $this->autor->id,
      'editor_id' => $this->editor->id,
      'publicador_id' => $this->publicador->id,
      'publicar' => now(),
      'created_at' => $faker->dateTimeBetween('-3 month,-1 week')
    ]);
    $post->tags()->sync([$this->tags[0]->id, $this->tags[1]->id]);
    return $post;
  }

  public function test_guess_accede_en_el_view_a_datos_del_post()
  {
    $response = $this->get('/');

    $responseStr = $response->__toString();
    $this->assertTrue(strpos($responseStr, 'id="imagen_post"') > 0);
  }
  public function test_guess_pueden_ver_el_nombre_del_post()
  {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee($this->post->name);
  }

  public function test_guess_pueden_ver_el_autor_del_post()
  {
    $response = $this->get('/');

    $response->assertSee($this->autor->name);
  }

  public function test_guess_pueden_ver_la_categoria_del_post()
  {
    $response = $this->get('/');

    $response->assertSee($this->categoria->name);
  }

  public function test_guess_pueden_ver_las_etiquetas_del_post()
  {
    $response = $this->get('/');
    $response->assertSee($this->tags[0]->name);
    $response->assertSee($this->tags[1]->name);
  }

  public function test_guess_pueden_ver_la_fecha_de_publicacion_del_post()
  {
    $response = $this->get('/');

    $response->assertSee(Carbon::parse($this->post->publicar)->format('j F, Y'));
  }

  public function test_guess_pueden_ver_el_extracto_del_post()
  {
    $response = $this->get('/');

    $response->assertSee($this->post->extract);
  }

  public function test_guess_pueden_ver_etiqueta_nuevo_del_post()
  {
    $response = $this->get('/');

    if (strtotime($this->post->publicar) == strtotime(today())) {
      $response->assertSee('¡Nuevo!');
    }
  }

  public function test_guess_no_pueden_ver_etiqueta_nuevo_del_post_si_se_publico_ayer()
  {
    $this->post->update(['publicar' => date('Y/m/d', strtotime("-1 days"))]);

    $response = $this->get('/');

    $response->assertDontSee('¡Nuevo!');
  }

  public function test_guess_pueden_ver_la_imagen_del_post()
  {
    $response = $this->get('/');
    $responseStr = $response->__toString();

    $this->assertTrue(strpos($responseStr, 'id="imagen_post"') > 0);
    $this->assertFalse(strpos($responseStr, 'id="imagen_default"') > 0);
    Storage::disk('public')->assertExists($this->post->image->url);
  }

  public function test_guess_pueden_ver_la_imagen_default_para_post()
  {
    $this->post->image->delete();
    $response = $this->get('/');
    $responseStr = $response->__toString();

    $this->assertTrue(strpos($responseStr, 'id="imagen_default"') > 0);
    $this->assertFalse(strpos($responseStr, 'id="imagen_post"') > 0);
    Storage::disk('public')->assertExists('/img-default/post-default.webp');
  }

  public function test_guess_puede_ver_componente_likes_en_el_post()
  {
    $this->get('/');

    $component = Livewire::test('show-like-post', ['post' => $this->post]);

    $component->assertStatus(200);
  }

  public function test_guess_puede_ver_un_like_asignado_al_post()
  {
    $this->get('/');

    $component = Livewire::test('show-like-post', ['post' => $this->post]);

    $component->assertSet('like', 1);
  }

  /*  public function test_guess_no_pueden_ver_componente_para_guardado_de_pagina()
  {
    $response = $this->get('/');
    $this->assertGuest($guard = null);
    /* 
    $response->assertSessionMissing('bookmark');
    $response->assertSessionMissing('unbookmark'); 

    $response = $this->actingAs($this->autor)->get('/');
    $this->assertAuthenticated($guard = null);


    $response = $this->actingAs($this->editor)->get('/');
    $this->assertAuthenticated($guard = null);


    $response = $this->actingAs($this->publicador)->get('/');
    $this->assertAuthenticated($guard = null);
  } */

  public function test_guess_accede_a_ver_el_post_completo()
  {
    $response = $this->get('/posts/' . $this->post->slug);
    $response->assertStatus(200);
  }
}
