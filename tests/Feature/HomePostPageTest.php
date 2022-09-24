<?php

namespace Tests\Feature;

use Faker\Factory;
use App\Models\Tag;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Livewire\Livewire;
use App\Models\Comment;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Maize\Markable\Models\Like;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StateSeeder;
use Maize\Markable\Models\Bookmark;
use Maize\Markable\Models\Favorite;
use Maize\Markable\Models\Reaction;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePostPageTest extends TestCase
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
    $this->tags = Tag::factory(2)->create();
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
  private function createComment($type = 'POST', User $user = null, $comment_id = null)
  {
    if($user == null){
      $user = $this->user;
    }
    if($type=='POST'){
      $comment=Comment::factory()->create([
        'user_id' => $user->id,
        'commentable_id' => $this->post->id,
      ]);
    } else {
      $comment=Comment::factory()->create([
        'user_id' => $user->id,
        'commentable_id' => $comment_id,
        'commentable_type' => 'App\Models\Comment',
      ]);
    }
    return $comment;
  }

  /* 
  **
  ** Test de Guess
  **
  */
  public function test_guess_accede_a_ver_el_post_completo()
  {
    $this->get('/posts/' . $this->post->slug)
            ->assertStatus(200);
  }

  public function test_guess_ve_la_imagen_por_default_del_post_cuando_este_no_tiene_una_definida()
  {
    $this->post->image()->delete();
    $response = $this->get('/posts/' . $this->post->slug);
    $response->assertStatus(200);

    $responseStr = $response->__toString();
    $this->assertFalse(strpos($responseStr, 'alt="imagen_post-'.$this->post->id.'"') > 0);
    $this->assertTrue(strpos($responseStr, 'alt="imagen_default-'.$this->post->id.'"') > 0);
    Storage::disk('public')->assertExists('/img-default/post-default.webp');
  }

  public function test_guess_ve_la_imagen_del_post_cuando_este_tiene_una_definida()
  {
    $response = $this->get('/posts/' . $this->post->slug);
    $response->assertStatus(200);

    $responseStr = $response->__toString();
    $this->assertTrue(strpos($responseStr, 'alt="imagen_post-'.$this->post->id.'"') > 0);
    $this->assertFalse(strpos($responseStr, 'alt="imagen_default-'.$this->post->id.'"') > 0);
    Storage::disk('public')->assertExists($this->post->image->url);
  }

  public function test_guess_pueden_ver_el_nombre_del_post()
  {
    $response = $this->get('/posts/' . $this->post->slug);
    $response->assertStatus(200);
    $response->assertSee($this->post->name);
  }

  public function test_guess_pueden_ver_el_autor_del_post()
  {
    $response = $this->get('/posts/' . $this->post->slug);

    $response->assertSee($this->autor->name);
  }

  public function test_guess_pueden_ver_el_correo_electronico_del_autor_del_post()
  {
    $response = $this->get('/posts/' . $this->post->slug);

    $response->assertSee($this->autor->email);
  }

  public function test_guess_pueden_ver_el_rol_del_autor_del_post()
  {

    $response = $this->get('/posts/' . $this->post->slug);
    foreach ($this->post->user->roles as $rol) {
      $response->assertSee($rol->name);
    }
  }

  public function test_guess_pueden_ver_la_foto_del_autor_del_post()
  {
    Config::set('tipo_imagen','FACE');
    Image::factory(1)->create([
      'imageable_id' => $this->autor->id,
      'imageable_type' => User::class
    ]);
    
    $this->autor->update(['profile_photo_path' => $this->autor->image->url]);

    Storage::disk('public')->assertExists($this->autor->image->url);

    $response = $this->get('/posts/' . $this->post->slug);
    $responseStr = $response->__toString();
    $this->assertTrue(strpos($responseStr, 'alt="img_autor"') > 0);

  }

  public function test_guess_pueden_ver_la_foto_de_default_del_autor_del_post_si_este_no_tiene_una()
  {
    $response = $this->get('/posts/' . $this->post->slug);
    $responseStr = $response->__toString();
    $this->assertFalse(strpos($responseStr, 'alt="img_autor"') > 0);
    $this->assertTrue(strpos($responseStr, 'alt="img_autor_default"') > 0);

  }
  
  public function test_guess_no_puede_ver_el_componente_de_seguimiento_del_autor_del_post()
  {
    $this->get('/posts/' . $this->post->slug)
      ->assertDontSeeLivewire('follow-model',['user' => $this->user] );
  }

  public function test_guess_puede_ver_componente_show_profile_del_autor_del_post_si_definio_su_perfil()
  {
    $faker = Factory::create();
    $gen = $faker->randomElement(['male', 'female']);
    $this->autor->profile()->create([
      'title' => $faker->title($gen),
      'biografia' => $faker->text(200),
      'website' => 'https://' . $faker->domainName(),
      'user_id' => $this->autor->id,
      'telegram' => 'https://' . $faker->domainName(),
      'facebook' => 'https://' . $faker->domainName(),
      'instagram' => 'https://' . $faker->domainName(),
      'twitter' => 'https://' . $faker->domainName(),
      'tiktok' => 'https://' . $faker->domainName(),
    ]);
    $this->get('/posts/' . $this->post->slug)
      ->assertSeeLivewire('show-profile',['author'=>$this->post->user] );

    Livewire::Test('show-profile',['author'=>$this->autor] )
      ->assertSee('¿Quien es '.$this->autor->name)
      ->assertSee('Post publicados')
      ->assertSee($this->post->name); 
  }

  public function test_guess_puede_ver_post_relacionados_de_igual_categoria_que_el_post_elegido()
  {
    $similar = $this->createPost();
    
    $response = $this->get('/posts/' . $this->post->slug)
      ->assertSee('Mas en '.$this->categoria->name)
      ->assertSee($similar->name);

    //El post similar no tiene imagen alt="img_similar_post-{{$post->id}}"
    $responseStr = $response->__toString();
    $this->assertFalse(strpos($responseStr, 'alt="img_similar_post-'.$similar->id.'"') > 0);
    $this->assertTrue(strpos($responseStr, 'alt="img_similar_default-'.$similar->id.'"') > 0);
    Storage::disk('public')->assertExists('/img-default/post-default.webp');

    //Se le agega imagen al post similar
    Image::factory(1)->create([
      'imageable_id' => $similar->id,
      'imageable_type' => Post::class,
    ]);
    $response = $this->get('/posts/' . $this->post->slug)
      ->assertSee('Mas en '.$this->categoria->name)
      ->assertSee($similar->name);

    $responseStr = $response->__toString();
    $this->assertTrue(strpos($responseStr, 'alt="img_similar_post-'.$similar->id.'"') > 0);
    $this->assertFalse(strpos($responseStr, 'alt="img_similar_default-'.$similar->id.'"') > 0);
    Storage::disk('public')->assertExists($similar->image->url);

  }

  public function test_guess_no_puede_ver_componente_show_profile_del_autor_del_post_sino_definio_su_perfil()
  {
    $this->get('/posts/' . $this->post->slug)
      ->assertDontSeeLivewire('show-profile',['author'=>$this->post->user] );
  }

  public function test_guess_pueden_ver_la_categoria_del_post()
  {
    $response = $this->get('/posts/' . $this->post->slug);

    $response->assertSee($this->categoria->name);
  }

  public function test_guess_pueden_ver_las_etiquetas_del_post()
  {
    $response = $this->get('/posts/' . $this->post->slug);
    $response->assertSee($this->tags[0]->name);
    $response->assertSee($this->tags[1]->name);
  }

  public function test_guess_pueden_ver_la_fecha_de_publicacion_del_post()
  {
    $response = $this->get('/posts/' . $this->post->slug);

    $response->assertSee(Carbon::parse($this->post->publicar)->format('j F, Y'));
  }

  public function test_guess_pueden_ver_el_extracto_del_post()
  {
    $response = $this->get('/posts/' . $this->post->slug);

    $response->assertSee($this->post->extract);
  }

  public function test_guess_pueden_ver_el_body_del_post()
  {
    $response = $this->get('/posts/' . $this->post->slug);

    $response->assertSee($this->post->body);
  }

  public function test_guess_pueden_ver_etiqueta_nuevo_del_post()
  {
    $response = $this->get('/posts/' . $this->post->slug);

    if (strtotime($this->post->publicar) == strtotime(today())) {
      $response->assertSee('¡Nuevo!');
    }
  }

  public function test_guess_no_pueden_ver_etiqueta_nuevo_del_post_si_se_publico_ayer()
  {
    $this->post->update(['publicar' => date('Y/m/d', strtotime("-1 days"))]);

    $response = $this->get('/posts/' . $this->post->slug);

    $response->assertDontSee('¡Nuevo!');
  }

  public function test_guess_no_puede_ver_componente_de_reaccion_al_post()
  {
    $this->get('/posts/' . $this->post->slug)
      ->assertDontSeeLivewire('reaction-post');
  } 
  
  /* Livewire bookmark */
  public function test_guess_no_puede_ver_componente_bookmark_en_el_post()
  {
    $this->get('/posts/' . $this->post->slug)->assertDontSeeLivewire('bookmark-card-post');
    
  }

  public function test_guess_el_post_no_se_ve_imagen_y_similares_muestran_default()
  {
    $this->post->image()->delete();
    
    $similar = $this->createPost();

    //Se le agega imagen al post similar
    Image::factory(1)->create([
      'imageable_id' => $similar->id,
      'imageable_type' => Post::class,
    ]);

    $response = $this->get('/posts/' . $this->post->slug)
      ->assertSee($similar->name)
      ->assertSee('Mas en '.$this->categoria->name);

    $responseStr = $response->__toString();
    $this->assertFalse(strpos($responseStr, 'alt="imagen_post-'.$this->post->id.'"' ) > 0);
    $this->assertTrue(strpos($responseStr, 'alt="img_similar_post-'.$similar->id.'"') > 0);
    $this->assertFalse(strpos($responseStr, 'alt="img_similar_default-'.$similar->id.'"') > 0);
    Storage::disk('public')->assertExists($similar->image->url);
  }

  public function test_guess_el_post_se_borra_fisicamente_la_imagen()
  {
    
    unlink(public_path('storage/'. $this->post->image->url));
    
    $this->assertFileDoesNotExist(public_path('storage/'. $this->post->image->url));

    $similar = $this->createPost();

    //Se le agega imagen al post similar
    Image::factory(1)->create([
      'imageable_id' => $similar->id,
      'imageable_type' => Post::class,
    ]);

    $response = $this->get('/posts/' . $this->post->slug)
      ->assertSee($similar->name)
      ->assertSee('Mas en '.$this->categoria->name);

    $responseStr = $response->__toString();
    $this->assertFalse(strpos($responseStr, 'alt="imagen_post-'.$this->post->id.'"' ) > 0);
    $this->assertTrue(strpos($responseStr, 'alt="img_similar_post-'.$similar->id.'"') > 0);
    $this->assertFalse(strpos($responseStr, 'alt="img_similar_default-'.$similar->id.'"') > 0);
    Storage::disk('public')->assertExists($similar->image->url);

  }

  public function test_guess_puede_ver_zona_de_comentarios_al_post_cuando_no_existen_comentarios()
  {
    $this->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::test('comments.show-post-comment',['post'=>$this->post])
      ->assertDontSeeHtml('alt="boton_actualizar"')
      ->assertDontSeeHtml('alt="boton_comentar"');
  }

  public function test_guess_puede_ver_comentarios_hechos_al_post()
  {
    $comment = $this->createComment();
    $this->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertDontSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSee($comment->user->name)
      ->assertSee($comment->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment])
      ->assertDontSeeHtml('alt="boton_comentar_'.$comment->id.'"')
      ->assertDontSeeHtml('alt="boton_borrar_'.$comment->id.'"');

    Livewire::test('reaction-comment',['comment'=>$comment])
      ->assertSee(0)
      ->assertPayloadSet('heart',0)
      ->assertSeeHtml('btn_heart_react_guess');
  }

  public function test_guess_puede_ver_comentario_con_comentario_hechos_al_post()
  {
    $comment = $this->createComment();
    $comment2 = $this->createComment('COMMENT',null,$comment->id);

    $this->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertDontSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSee($comment->user->name)
      ->assertSee($comment->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment])
      ->assertSeeLivewire('comments.show-comment',['comment'=>$comment2])
      ->assertDontSeeHtml('alt="boton_comentar_'.$comment->id.'"')
      ->assertDontSeeHtml('alt="boton_borrar_'.$comment->id.'"');
      
    Livewire::test('reaction-comment',['comment'=>$comment])
    ->assertSee(0)
    ->assertPayloadSet('heart',0)
    ->assertSeeHtml('btn_heart_react_guess');

    Livewire::test('comments.show-comment',['comment'=> $comment2,'masSangria'=> 4])
      ->assertSee($comment2->user->name)
      ->assertSee($comment2->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment2])
      ->assertDontSeeHtml('alt="boton_comentar_'.$comment2->id.'"')
      ->assertDontSeeHtml('alt="boton_borrar_'.$comment2->id.'"');

    Livewire::test('reaction-comment',['comment'=>$comment2])
      ->assertSee(0)
      ->assertPayloadSet('heart',0)
      ->assertSeeHtml('btn_heart_react_guess');

  }

  public function test_guess_puede_ver_foto_del_autor_del_comentario_hecho_al_post_o_default_de_la_foto()
  {
    /* Ver default porque el comentador no tiene imagen */
    $comment = $this->createComment();

    $this->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertDontSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeHtml('alt="foto_default"');

    /* El comentador tiene imagen */
    Config::set('tipo_imagen','FACE');
    Image::factory(1)->create([
      'imageable_id' => $comment->user->id,
      'imageable_type' => User::class
    ]);    
    $comment->user->update(['profile_photo_path' => $comment->user->image->url]);    

    $this->assertFileExists(public_path('storage/'.$comment->user->image->url));

    $this->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertDontSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeHtml('alt="foto_comentador"');

    /* Se borrar fisicamente la imagen */
    unlink(public_path('storage/'. $this->user->image->url));
    $this->assertFileDoesNotExist(public_path('storage/'. $this->user->image->url));
    $this->get('/posts/' . $this->post->slug);
    Livewire::test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeHtml('alt="foto_default"');
    
    /* Se borra la relacion con la imagen */
    $comment->user->update(['profile_photo_path' => null]);
    $this->user->image->delete();
    $this->get('/posts/' . $this->post->slug);
    Livewire::test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeHtml('alt="foto_default"');

  }
  public function test_guess_puede_ver_reacciones_hechas_a_comentarios_del_post()
  {
    $comment = $this->createComment();
    Reaction::add($comment,$this->autor,'heart');

    $this->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertDontSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment]);

    Livewire::test('reaction-comment',['comment'=>$comment])
      ->assertSee(1)
      ->assertPayloadSet('heart',1)
      ->assertSeeHtml('btn_heart_react_guess');
  }
  /* 
  **
  ** Test de usuario registrado 
  **
  */
  
  public function test_usuario_registrado_accede_a_ver_el_post_completo()
  {
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug)
            ->assertStatus(200);
  }
  
  public function test_usuario_registrado_ve_la_imagen_por_default_del_post_cuando_este_no_tiene_una_definida()
  {
    $this->post->image()->delete();
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);
    $response->assertStatus(200);

    $responseStr = $response->__toString();
    $this->assertFalse(strpos($responseStr, 'alt="imagen_post-'.$this->post->id.'"') > 0);
    $this->assertTrue(strpos($responseStr, 'alt="imagen_default-'.$this->post->id.'"') > 0);
    Storage::disk('public')->assertExists('/img-default/post-default.webp');
  }

  public function test_usuario_registrado_ve_la_imagen_del_post_cuando_este_tiene_una_definida()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);
    $response->assertStatus(200);

    $responseStr = $response->__toString();
    $this->assertTrue(strpos($responseStr, 'alt="imagen_post-'.$this->post->id.'"') > 0);
    $this->assertFalse(strpos($responseStr, 'alt="imagen_default-'.$this->post->id.'"') > 0);
    Storage::disk('public')->assertExists($this->post->image->url);
  }

  public function test_usuario_registrado_pueden_ver_el_nombre_del_post()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);
    $response->assertStatus(200);
    $response->assertSee($this->post->name);
  }

  public function test_usuario_registrado_pueden_ver_el_autor_del_post()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    $response->assertSee($this->autor->name);
  }

  public function test_usuario_registrado_pueden_ver_el_correo_electronico_del_autor_del_post()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    $response->assertSee($this->autor->email);
  }

  public function test_usuario_registrado_pueden_ver_el_rol_del_autor_del_post()
  {

    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);
    foreach ($this->post->user->roles as $rol) {
      $response->assertSee($rol->name);
    }
  }

  public function test_usuario_registrado_pueden_ver_la_foto_del_autor_del_post()
  {
    Config::set('tipo_imagen','FACE');
    Image::factory(1)->create([
      'imageable_id' => $this->autor->id,
      'imageable_type' => User::class
    ]);
    
    $this->autor->update(['profile_photo_path' => $this->autor->image->url]);

    Storage::disk('public')->assertExists($this->autor->image->url);

    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);
    $responseStr = $response->__toString();
    $this->assertTrue(strpos($responseStr, 'alt="img_autor"') > 0);

  }

  public function test_usuario_registrado_pueden_ver_la_foto_de_default_del_autor_del_post_si_este_no_tiene_una()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);
    $responseStr = $response->__toString();
    $this->assertFalse(strpos($responseStr, 'alt="img_autor"') > 0);
    $this->assertTrue(strpos($responseStr, 'alt="img_autor_default"') > 0);

  }
  
  public function test_usuario_registrado_puede_ver_el_componente_de_seguimiento_del_autor_del_post()
  {
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug)
      ->assertSeeLivewire('follow-model',['user' => $this->user] );
  }

  public function test_usuario_registrado_puede_ver_componente_show_profile_del_autor_del_post_si_definio_su_perfil()
  {
    $faker = Factory::create();
    $gen = $faker->randomElement(['male', 'female']);
    $this->autor->profile()->create([
      'title' => $faker->title($gen),
      'biografia' => $faker->text(200),
      'website' => 'https://' . $faker->domainName(),
      'user_id' => $this->autor->id,
      'telegram' => 'https://' . $faker->domainName(),
      'facebook' => 'https://' . $faker->domainName(),
      'instagram' => 'https://' . $faker->domainName(),
      'twitter' => 'https://' . $faker->domainName(),
      'tiktok' => 'https://' . $faker->domainName(),
    ]);
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug)
      ->assertSeeLivewire('show-profile',['author'=>$this->post->user] );

    Livewire::actingAs($this->user)
      ->Test('show-profile',['author'=>$this->autor] )
      ->assertSee('¿Quien es '.$this->autor->name)
      ->assertSee('Post publicados')
      ->assertSee($this->post->name); 
  }

  public function test_usuario_registrado_puede_ver_post_relacionados_de_igual_categoria_que_el_post_elegido()
  {
    $similar = $this->createPost();
    
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug)
      ->assertSee('Mas en '.$this->categoria->name)
      ->assertSee($similar->name);

    //El post similar no tiene imagen alt="img_similar_post-{{$post->id}}"
    $responseStr = $response->__toString();
    $this->assertFalse(strpos($responseStr, 'alt="img_similar_post-'.$similar->id.'"') > 0);
    $this->assertTrue(strpos($responseStr, 'alt="img_similar_default-'.$similar->id.'"') > 0);
    Storage::disk('public')->assertExists('/img-default/post-default.webp');

    //Se le agega imagen al post similar
    Image::factory(1)->create([
      'imageable_id' => $similar->id,
      'imageable_type' => Post::class,
    ]);
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug)
      ->assertSee('Mas en '.$this->categoria->name)
      ->assertSee($similar->name);

    $responseStr = $response->__toString();
    $this->assertTrue(strpos($responseStr, 'alt="img_similar_post-'.$similar->id.'"') > 0);
    $this->assertFalse(strpos($responseStr, 'alt="img_similar_default-'.$similar->id.'"') > 0);
    Storage::disk('public')->assertExists($similar->image->url);

  }

  public function test_usuario_registrado_no_puede_ver_componente_show_profile_del_autor_del_post_sino_definio_su_perfil()
  {
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug)
      ->assertDontSeeLivewire('show-profile',['author'=>$this->post->user] );
  }

  public function test_usuario_registrado_pueden_ver_la_categoria_del_post()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    $response->assertSee($this->categoria->name);
  }

  public function test_usuario_registrado_pueden_ver_las_etiquetas_del_post()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);
    $response->assertSee($this->tags[0]->name);
    $response->assertSee($this->tags[1]->name);
  }

  public function test_usuario_registrado_pueden_ver_la_fecha_de_publicacion_del_post()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    $response->assertSee(Carbon::parse($this->post->publicar)->format('j F, Y'));
  }

  public function test_usuario_registrado_pueden_ver_el_extracto_del_post()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    $response->assertSee($this->post->extract);
  }

  public function test_usuario_registrado_pueden_ver_el_body_del_post()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    $response->assertSee($this->post->body);
  }

  public function test_usuario_registrado_pueden_ver_etiqueta_nuevo_del_post()
  {
    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    if (strtotime($this->post->publicar) == strtotime(today())) {
      $response->assertSee('¡Nuevo!');
    }
  }

  public function test_usuario_registrado_no_pueden_ver_etiqueta_nuevo_del_post_si_se_publico_ayer()
  {
    $this->post->update(['publicar' => date('Y/m/d', strtotime("-1 days"))]);

    $response = $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    $response->assertDontSee('¡Nuevo!');
  }
  
  /* Livewire reaction */
  public function test_usuario_registrado_puede_ver_componente_de_reaccion_al_post()
  {
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug)
      ->assertSeeLivewire('reaction-post',['type'=>'thumbup', 'post'=>$this->post, 'group'=>'+'])
      ->assertSeeLivewire('reaction-post',['type'=>'heart', 'post'=>$this->post, 'group'=>'+'])
      ->assertSeeLivewire('reaction-post',['type'=>'start', 'post'=>$this->post, 'group'=>'+'])
      ->assertSeeLivewire('reaction-post',['type'=>'thumbdown', 'post'=>$this->post, 'group'=>'-'])
      ->assertSeeLivewire('reaction-post',['type'=>'brokenheart', 'post'=>$this->post, 'group'=>'-'])
      ->assertSeeLivewire('reaction-post',['type'=>'unhappy', 'post'=>$this->post, 'group'=>'-']);
  } 
  public function test_usuario_registrado_ve_reaccion_elegida_en_el_post()
  {
    // reaccion positiva que tiene el post puesta por el usuario registrado
    $react = $this->post->firstOrFail()->reactions[0]->value;

    $this->assertTrue(Like::count($this->post)==1);
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    Livewire::actingAs($this->user)
      ->test('reaction-post',['type'=> $react, 'post'=>$this->post, 'group'=>'+'])
      ->assertSeeHtml('alt="'.$react.'-on"');
  }
  
  public function test_usuario_registrado_cambia_reaccion_elegida_en_el_post_satisfactoriamente()
  {
    // reaccion positiva que tiene el post puesta por el usuario registrado
    $react = $this->post->firstOrFail()->reactions[0]->value;

    $this->assertTrue(Like::count($this->post)==1);
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    Livewire::actingAs($this->user)
      ->test('reaction-post',['type'=> $react, 'post'=>$this->post, 'group'=>'+'])
      ->assertSeeHtml('alt="'.$react.'-on"')
      ->call('unreact')
      ->assertSeeHtml('alt="'.$react.'-off"');

    $this->assertTrue(Like::count($this->post)==0);
  }

  public function test_usuario_registrado_agrega_reacciones_positivas_y_negativas_en_el_post_satisfactoriamente()
  {
    // reaccion positiva que tiene el post puesta por el usuario registrado
    $react = $this->post->firstOrFail()->reactions[0]->value;

    $this->assertTrue(Like::count($this->post)==1);
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug);

    Livewire::actingAs($this->user)
      ->test('reaction-post',['type'=> $react, 'post'=>$this->post, 'group'=>'+'])
      ->assertSeeHtml('alt="'.$react.'-on"')
      ->call('unreact')
      ->assertSeeHtml('alt="'.$react.'-off"');

    $this->assertTrue(Like::count($this->post)==0);

    Livewire::actingAs($this->user)
      ->test('reaction-post',['type'=> 'thumbup', 'post'=>$this->post, 'group'=>'+'])
      ->call('react')
      ->assertSeeHtml('alt="'.'thumbup-on"')
      ->assertEmitted('pos')
      ->call('positive');
    Livewire::actingAs($this->user)
      ->test('reaction-post',['type'=> 'heart', 'post'=>$this->post, 'group'=>'+'])
      ->call('react')
      ->assertSeeHtml('alt="'.'heart-on"')
      ->assertEmitted('pos')
      ->call('positive');
    Livewire::actingAs($this->user)
      ->test('reaction-post',['type'=> 'star', 'post'=>$this->post, 'group'=>'+'])
      ->call('react')
      ->assertSeeHtml('alt="'.'star-on"')
      ->assertEmitted('pos')
      ->call('positive');

    $this->assertTrue(Like::count($this->post)==1);
    
    Livewire::actingAs($this->user)
      ->test('reaction-post',['type'=> 'thumbdown', 'post'=>$this->post, 'group'=>'-'])
      ->call('react')
      ->assertSeeHtml('alt="'.'thumbdown-on"')
      ->assertEmitted('neg')
      ->call('negative');
      
    Livewire::actingAs($this->user)
      ->test('reaction-post',['type'=> 'thumbup', 'post'=>$this->post, 'group'=>'+'])
      ->call('negative');
    Livewire::actingAs($this->user)
      ->test('reaction-post',['type'=> 'heart', 'post'=>$this->post, 'group'=>'+'])
      ->call('negative');
    Livewire::actingAs($this->user)
      ->test('reaction-post',['type'=> 'star', 'post'=>$this->post, 'group'=>'+'])
      ->call('negative');

      $this->assertTrue(Like::count($this->post)==0);
  }

  /* Livewire bookmark */
  public function test_usuario_registrado_puede_ver_componente_bookmark_en_el_post()
  {
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug)->assertSeeLivewire('bookmark-card-post');
  }

  public function test_usuario_registrado_que_selecciono_un_post_puede_ver_seleccionado_el_icono_bookmark_del_post()
  {
    $this->assertTrue(Bookmark::has($this->post,$this->user)); // el usuario eligio este post
    
     // usuario registrado ve el componente
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug)->assertSeeLivewire('bookmark-card-post');

    Livewire::actingAs($this->user)
      ->test('bookmark-card-post', ['post'=> $this->post])
      ->assertSeeHtml('alt="bookmark_select"');
  }

  public function test_usuario_registrado_que_no_selecciono_un_post_puede_ver_no_seleccionado_el_icono_bookmark_del_post()
  {
    $this->assertFalse(Bookmark::has($this->post,$this->editor)); // el editor no eligio este post

    $this->actingAs($this->editor)->get('/posts/' . $this->post->slug)->assertSeeLivewire('bookmark-card-post'); // usuario registrado ve el componente

    Livewire::actingAs($this->editor)
      ->test('bookmark-card-post', ['post'=> $this->post])
      ->assertSeeHtml('alt="bookmark_unselect"');
  }

  public function test_usuario_registrado_que_guardo_post_lo_deselecciona()
  {
    $this->assertTrue(Bookmark::has($this->post,$this->user)); // el usuario eligio este post

    $this->actingAs($this->user)->get('/posts/' . $this->post->slug)->assertSeeLivewire('bookmark-card-post'); // usuario registrado ve el componente

    // antes lo ve seleccionado, luego aparde deseleccionado
    Livewire::actingAs($this->user)
      ->test('bookmark-card-post', ['post'=> $this->post])
      ->assertSeeHtml('alt="bookmark_select"')
      ->call('unbookmark')
      ->assertSeeHtml('alt="bookmark_unselect"');
  }

  public function test_usuario_registrado_que_no_guardo_post_lo_selecciona()
  {
    $this->assertFalse(Bookmark::has($this->post,$this->editor)); // el editor no eligio este post

    $this->actingAs($this->editor)->get('/posts/' . $this->post->slug)->assertSeeLivewire('bookmark-card-post'); // usuario registrado ve el componente

    // antes lo ve seleccionado, luego aparde deseleccionado
    Livewire::actingAs($this->editor)
      ->test('bookmark-card-post', ['post'=> $this->post])
      ->assertSeeHtml('alt="bookmark_unselect"')
      ->call('bookmark')
      ->assertSeeHtml('alt="bookmark_select"');
  }

  public function test_usuario_registrado_que_guardo_post_lo_ve_en_post_guardado()
  {
    $this->assertTrue(Bookmark::has($this->post,$this->user)); // el user eligio este post

    $this->actingAs($this->user)
      ->get('/posts/misposts/1')
      ->assertSee($this->post->name);
   
    Livewire::actingAs($this->user)
      ->test('bookmark-card-post', ['post'=> $this->post])
      ->assertSeeHtml('alt="bookmark_select"');
  }

  public function test_usuario_registrado_que_no_guardo_post_no_ve_el_post_como_guardado()
  {
    $this->assertFalse(Bookmark::has($this->post,$this->editor)); // el editor no eligio este post

    $this->actingAs($this->editor)
      ->get('/posts/misposts/1')
      ->assertSee('No hay posts para ver.');
  }

  public function test_usuario_registrado_elige_seguir_al_autor_del_post()
  {
    $this->assertFalse(Favorite::has($this->autor,$this->user)); //el usuario registrado no sigue al autor del post
    $this->actingAs($this->user)
      ->get('/posts/misposts/4')
      ->assertSee('No hay posts para ver'); //No hay post para ver en Mis autores del usuario registrado

    $this->actingAs($this->user)->get('/posts/' . $this->post->slug)
      ->assertSeeLivewire('follow-model',['user' => $this->autor]);

    Livewire::actingAs($this->user) 
      ->test('follow-model',['user' => $this->autor])
      ->call('user_like')
      ->assertSeeHtml('alt="fav_autor_select"');

    $this->assertTrue(Favorite::has($this->autor,$this->user)); //el usuario registrado sigue al autor del post
    $this->actingAs($this->user)
      ->get('/posts/misposts/4')
      ->assertSee($this->post->name); //El post del autor seguido, es visible para el usuario registrado
  }
  
  public function test_usuario_registrado_puede_ver_zona_de_comentarios_al_post_cuando_no_existen_comentarios()
  {
    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertDontSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"');

  }
  
  public function test_usuario_registrado_puede_ver_comentarios_hechos_al_post()
  {
    $comment = $this->createComment('POST',$this->editor);
    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSee($comment->user->name)
      ->assertSee($comment->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment])
      ->assertSeeHtml('alt="boton_comentar_'.$comment->id.'"')
      ->assertDontSeeHtml('alt="boton_borrar_'.$comment->id.'"');

    Livewire::actingAs($this->user)
      ->test('reaction-comment',['comment'=>$comment])
      ->assertSee(0)
      ->assertPayloadSet('heart',0)
      ->assertSeeHtml('btn_heart_react');
  }

  public function test_usuario_registrado_puede_hacer_y_ver_comentarios_hechos_al_post()
  {
    $comment1 = $this->createComment('POST',$this->editor);
    $comment2 = $this->createComment();

    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment1,'masSangria'=> 0])
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment2,'masSangria'=> 0]);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment1,'masSangria'=> 0])
      ->assertSee($comment1->user->name)
      ->assertSee($comment1->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment1])
      ->assertSeeHtml('alt="boton_comentar_'.$comment1->id.'"')
      ->assertDontSeeHtml('alt="boton_borrar_'.$comment1->id.'"');

    Livewire::actingAs($this->user)
      ->test('reaction-comment',['comment'=>$comment1])
      ->assertSee(0)
      ->assertPayloadSet('heart',0)
      ->assertSeeHtml('btn_heart_react');

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment2,'masSangria'=> 0])
      ->assertSee($comment2->user->name)
      ->assertSee($comment2->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment2])
      ->assertSeeHtml('alt="boton_comentar_'.$comment2->id.'"')
      ->assertSeeHtml('alt="boton_borrar_'.$comment2->id.'"');

    Livewire::actingAs($this->user)
      ->test('reaction-comment',['comment'=>$comment2])
      ->assertSee(0)
      ->assertPayloadSet('heart',0)
      ->assertSeeHtml('btn_heart_react_autor');
  }
  public function test_usuario_registrado_puede_ver_comentario_con_comentario_hechos_al_post()
  {
    $comment = $this->createComment();
    $comment2 = $this->createComment('COMMENT',null,$comment->id);

    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment2,'masSangria'=> 0]);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSee($comment->user->name)
      ->assertSee($comment->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment])
      ->assertSeeLivewire('comments.show-comment',['comment'=>$comment2])
      ->assertSeeHtml('alt="boton_comentar_'.$comment->id.'"')
      ->assertDontSeeHtml('alt="boton_borrar_'.$comment->id.'"');
      
    Livewire::actingAs($this->user)
    ->test('reaction-comment',['comment'=>$comment])
    ->assertSee(0)
    ->assertPayloadSet('heart',0)
    ->assertSeeHtml('btn_heart_react_autor');

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment2,'masSangria'=> 4])
      ->assertSee($comment2->user->name)
      ->assertSee($comment2->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment2])
      ->assertSeeHtml('alt="boton_comentar_'.$comment2->id.'"')
      ->assertSeeHtml('alt="boton_borrar_'.$comment2->id.'"');

    Livewire::actingAs($this->user)
      ->test('reaction-comment',['comment'=>$comment2])
      ->assertSee(0)
      ->assertPayloadSet('heart',0)
      ->assertSeeHtml('btn_heart_react_autor');

  }

  public function test_usuario_registrado_puede_ver_foto_del_autor_del_comentario_hecho_al_post_o_default_de_la_foto()
  {
    /* Ver default porque el comentador no tiene imagen */
    $comment = $this->createComment();

    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeHtml('alt="foto_default"');

    /* El comentador tiene imagen */
    Config::set('tipo_imagen','FACE');
    Image::factory(1)->create([
      'imageable_id' => $comment->user->id,
      'imageable_type' => User::class
    ]);    
    $comment->user->update(['profile_photo_path' => $comment->user->image->url]);    

    $this->assertFileExists(public_path('storage/'.$comment->user->image->url));

    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeHtml('alt="foto_comentador"');

    /* Se borrar fisicamente la imagen */
    unlink(public_path('storage/'. $this->user->image->url));
    $this->assertFileDoesNotExist(public_path('storage/'. $this->user->image->url));
    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug);
    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeHtml('alt="foto_default"');
    
    /* Se borra la relacion con la imagen */
    $comment->user->update(['profile_photo_path' => null]);
    $this->user->image->delete();
    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug);
    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeHtml('alt="foto_default"');

  }
  public function test_usuario_registrado_puede_ver_reacciones_hechas_a_sus_comentarios_del_post()
  {
    $comment = $this->createComment();
    Reaction::add($comment,$this->autor,'heart');

    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment]);

    Livewire::actingAs($this->user)
      ->test('reaction-comment',['comment'=>$comment])
      ->assertSee(1)
      ->assertPayloadSet('heart',1)
      ->assertSeeHtml('btn_heart_react_autor');
  }
  public function test_usuario_registrado_puede_reaccionar_a_comentarios_no_propios_del_post()
  {
    $comment = $this->createComment('POST',$this->autor);
    Reaction::add($comment,$this->user,'heart');

    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug)
      ->assertSee('Comentarios al post')
      ->assertSeeLivewire('comments.show-post-comment',['post'=>$this->post]);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment]);

    Livewire::actingAs($this->user)
      ->test('reaction-comment',['comment'=>$comment])
      ->assertSee(1)
      ->assertPayloadSet('heart',1)
      ->assertSeeHtml('btn_heart_unreact')
      ->call('unreact')
      ->assertSee(0)
      ->assertPayloadSet('heart',0)
      ->assertSeeHtml('btn_heart_react');
  }
  public function test_usuario_registrado_puede_borrar_comentarios_hechos_solo_si_no_tiene_replica_ni_reaccion()
  {
    $comment1 = $this->createComment();
    $comment2 = $this->createComment();
    $comment3 = $this->createComment();
    $comment4 = $this->createComment('COMMENT',$this->autor,$comment1->id);
    Reaction::add($comment2,$this->autor,'heart');
    
    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment1,'masSangria'=> 0])
      ->assertDontSeeHtml('alt="boton_borrar_'.$comment1->id.'"');
    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment2,'masSangria'=> 0])
      ->assertDontSeeHtml('alt="boton_borrar_'.$comment2->id.'"');
    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment3,'masSangria'=> 0])
      ->assertSeeHtml('alt="boton_borrar_'.$comment3->id.'"');

  }
  public function test_usuario_registrado_prueba_funcionamiento_input_para_comentar_un_post()
  {
    $this->actingAs($this->user)
      ->get('/posts/' . $this->post->slug);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertDontSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->call('toogle')
      ->assertSeeLivewire('comments.modal-input-comment', ['comentario_id' => 0, 'post_id' => $this->post->id])
      ->assertSee('Su comentario')
      ->assertSee('Comentar');

    Livewire::actingAs($this->user)
      ->test('comments.modal-input-comment', ['comentario_id' => 0, 'post_id' => $this->post->id])
      ->set('comentario','Este es un comentario al post.')
      ->call('store')
      ->assertEmitted('recargar')
      ->assertPayloadSet('comentario','')
      ->assertPayloadSet('verModal','invisible');

    $comment = Comment::first();
    
    $this->assertTrue($comment->mensaje == 'Este es un comentario al post.');
    $this->assertTrue($comment->user_id == $this->user->id);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->call('recargar')
      ->assertPayloadSet('verModal','invisible')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);
    
    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSee($this->user->name)
      ->assertSee('Este es un comentario al post.')
      ->assertSeeHtml('alt="foto_default"')
      ->assertSeeHtml('alt="boton_comentar_'.$comment->id.'"')
      ->assertSeeHtml('alt="boton_borrar_'.$comment->id.'"')
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment]);
      
    Livewire::actingAs($this->user)
      ->test('reaction-comment',['comment'=>$comment])
      ->assertSee(0)
      ->assertPayloadSet('heart',0)
      ->assertSeeHtml('btn_heart_react_autor');
  }
  public function test_usuario_registrado_prueba_funcionamiento_input_para_comentar_un_comentario()
  {
    $comment = $this->createComment();

    $this->actingAs($this->user)
    ->get('/posts/' . $this->post->slug);
    
    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSee($comment->user->name)
      ->assertSee($comment->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment])
      ->assertSeeHtml('alt="boton_comentar_'.$comment->id.'"')
      ->assertSeeHtml('alt="boton_borrar_'.$comment->id.'"')
      ->call('toogleModal')
      ->assertSeeLivewire('comments.modal-input-comment', ['comentario_id' => $comment->id , 'post_id' => 0])
      ->assertSee('Su comentario')
      ->assertSee('Comentar');

    Livewire::actingAs($this->user)
      ->test('comments.modal-input-comment', ['comentario_id' => $comment->id , 'post_id' => 0])
      ->set('comentario','Este es un comentario al comentario del post.')
      ->call('store')
      ->assertEmitted('recargar')
      ->assertPayloadSet('comentario','')
      ->assertPayloadSet('verModal','invisible');

    $comment->load('replies');
    $comment2 = $comment->replies[0];

    $this->assertTrue($comment2->mensaje == 'Este es un comentario al comentario del post.');
    $this->assertTrue($comment2->user_id == $this->user->id);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->call('recargar')
      ->assertPayloadSet('verModal','invisible')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment2,'masSangria'=> 0]);
    
    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment2,'masSangria'=> 0])
      ->assertSee($this->user->name)
      ->assertSee('Este es un comentario al comentario del post.')
      ->assertSeeHtml('alt="foto_default"')
      ->assertSeeHtml('alt="boton_comentar_'.$comment2->id.'"')
      ->assertSeeHtml('alt="boton_borrar_'.$comment2->id.'"')
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment2]);
      
    Livewire::actingAs($this->user)
      ->test('reaction-comment',['comment'=>$comment2])
      ->assertSee(0)
      ->assertPayloadSet('heart',0)
      ->assertSeeHtml('btn_heart_react_autor');
  }
  public function test_usuario_registrado_prueba_de_borrado_de_un_comentario_a_un_post()
  {
    $comment = $this->createComment();
    $this->assertTrue($this->post->comments->count() == 1);
    $this->actingAs($this->user)
    ->get('/posts/' . $this->post->slug);
    
    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0]);

    $this->assertTrue($comment->replies->count()==0);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment,'masSangria'=> 0])
      ->assertSee($comment->user->name)
      ->assertSee($comment->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment])
      ->assertSeeHtml('alt="boton_comentar_'.$comment->id.'"')
      ->assertSeeHtml('alt="boton_borrar_'.$comment->id.'"')
      ->set('confirmingDeletion',true)
      ->assertSee('¿seguro borra su comentario?')
      ->assertSee('Si')
      ->assertSee('No')
      ->call('delete')
      ->assertPayloadSet('confirmingDeletion',false)
      ->assertPayloadSet('verComponente',false)
      ->assertEmitted('recargar');

    $this->assertTrue(Comment::all()->count() == 0);
    $this->post->load('comments');
    $this->assertTrue($this->post->comments->count() == 0);

    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertDontSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertDontSee($comment->mensaje);
  }
  public function test_usuario_registrado_prueba_de_borrado_de_un_comentario_a_un_comentario_de_un_post()
  {
    $comment1 = $this->createComment();
    $comment2 = $this->createComment('COMMENT', null, $comment1->id);
    $this->assertTrue($this->post->comments->count() == 1);
    $this->assertTrue(Comment::all()->count()==2);

    $this->actingAs($this->user)
    ->get('/posts/' . $this->post->slug);
    
    Livewire::actingAs($this->user)
      ->test('comments.show-post-comment',['post'=>$this->post])
      ->assertSeeHtml('alt="boton_actualizar"')
      ->assertSeeHtml('alt="boton_comentar"')
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment1,'masSangria'=> 0])
      ->assertSeeLivewire('comments.show-comment',['comment'=> $comment2,'masSangria'=> 0]);

    $this->assertTrue($comment1->replies->count()==1);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment1,'masSangria'=> 0])
      ->assertSee($comment1->user->name)
      ->assertSee($comment1->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment1])
      ->assertSeeHtml('alt="boton_comentar_'.$comment1->id.'"')
      ->assertDontSeeHtml('alt="boton_borrar_'.$comment1->id.'"');

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment2,'masSangria'=> 0])
      ->assertSee($comment2->user->name)
      ->assertSee($comment2->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment2])
      ->assertSeeHtml('alt="boton_comentar_'.$comment2->id.'"')
      ->assertSeeHtml('alt="boton_borrar_'.$comment2->id.'"')
      ->set('confirmingDeletion',true)
      ->assertSee('¿seguro borra su comentario?')
      ->assertSee('Si')
      ->assertSee('No')
      ->call('delete')
      ->assertPayloadSet('confirmingDeletion',false)
      ->assertPayloadSet('verComponente',false)
      ->assertEmitted('recargar');

    $this->assertTrue(Comment::all()->count() == 1);
    $this->post->load('comments');
    $comment1->load('replies');
    $this->assertTrue($this->post->comments->count() == 1);
    $this->assertTrue($comment1->replies->count() == 0);

    Livewire::actingAs($this->user)
      ->test('comments.show-comment',['comment'=> $comment1,'masSangria'=> 0])
      ->assertSee($comment1->user->name)
      ->assertSee($comment1->mensaje)
      ->assertSeeLivewire('reaction-comment',['comment'=>$comment1])
      ->assertSeeHtml('alt="boton_comentar_'.$comment1->id.'"')
      ->assertSeeHtml('alt="boton_borrar_'.$comment1->id.'"')
      ->assertDontSee($comment2->mensaje);
  }
}
