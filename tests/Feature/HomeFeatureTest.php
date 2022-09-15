<?php

namespace Tests\Feature;

use Faker\Factory;
use App\Models\Tag;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

use App\Models\Image;
use App\Models\State;
use Livewire\Livewire;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Maize\Markable\Models\Like;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StateSeeder;
use Illuminate\Support\Facades\DB;
use Maize\Markable\Models\Bookmark;
use Maize\Markable\Models\Favorite;
use Maize\Markable\Models\Reaction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

  /* 
  **
  ** Test de Guess
  **
  */
  public function test_guess_ve_la_imagen_por_default_del_post_cuando_este_no_tiene_una_definida()
  {
    $this->post->image->delete();
    $response = $this->get('/');
    $response->assertStatus(200);

    $responseStr = $response->__toString();
    $this->assertFalse(strpos($responseStr, 'alt="imagen_post-'.$this->post->id.'"') > 0);
    $this->assertTrue(strpos($responseStr, 'alt="imagen_default-'.$this->post->id.'"') > 0);
    Storage::disk('public')->assertExists('/img-default/post-default.webp');
  }
  public function test_guess_ve_la_imagen_del_post_cuando_este_tiene_una_definida()
  {
    $response = $this->get('/');
    $response->assertStatus(200);

    $responseStr = $response->__toString();
    $this->assertTrue(strpos($responseStr, 'alt="imagen_post-'.$this->post->id.'"') > 0);
    $this->assertFalse(strpos($responseStr, 'alt="imagen_default-'.$this->post->id.'"') > 0);
    Storage::disk('public')->assertExists($this->post->image->url);
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
  
  /* Livewire bookmark */
  public function test_guess_no_puede_ver_componente_bookmark_en_el_post()
  {
    $this->get('/')->assertDontSeeLivewire('bookmark-card-post');
    
  }

  public function test_guess_puede_ver_componente_likes_en_el_post()
  {
    $this->get('/');

    Livewire::test('show-like-post', ['post' => $this->post])
        ->assertStatus(200);
  }

  public function test_guess_puede_ver_un_like_asignado_al_post()
  {
    $this->get('/')
      ->assertSeeLivewire('show-like-post', ['post' => $this->post]);

    Livewire::test('show-like-post', ['post' => $this->post])
      ->assertPayloadSet('like', 1)
      ->assertSee(1);
  }

  public function test_guess_no_puede_ver_reacciones_asignadas_al_post()
  {
    $this->get('/')
      ->assertDontSeeLivewire('show-reaction-post', ['post' => $this->post]);
  }
  
  public function test_guess_accede_a_ver_el_post_completo()
  {
    $response = $this->get('/posts/' . $this->post->slug);
    $response->assertStatus(200);
  }
  public function test_guess_seleccionar_posts_solo_del_autor_clickeado()
  {
    $this->get('/')
      ->assertSeeLivewire('posts.show-card-post', ['post'=>$this->post, 'indice'=> 0])
      ->assertDontSeeLivewire('follow-model',['user' => $this->user] );

    Livewire::test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('autor',$this->post->user)
      ->assertEmitted('askAutor',$this->post->user);

    Livewire::test('posts.show-index-post')
      ->call('askAutor',$this->post->user)
      ->assertSee('Autor')
      ->assertSee($this->post->user->name)
      ->assertPayloadSet('type', 'Autor');
  }
  public function test_guess_seleccionar_posts_solo_de_la_categoria_clickeada()
  {
    $this->get('/')
      ->assertSeeLivewire('posts.show-card-post', ['post'=>$this->post, 'indice'=> 0])
      ->assertDontSeeLivewire('follow-model',['categoria' => $this->post->categoria] );

    Livewire::test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('categoria',$this->post->categoria->id)
      ->assertEmitted('askCategoria',$this->post->categoria->id);

    Livewire::test('posts.show-index-post')
      ->call('askCategoria',$this->post->categoria->id)
      ->assertSee('Categoria')
      ->assertSee($this->post->categoria->name)
      ->assertPayloadSet('type', 'Categoria');
  }
  public function test_guess_seleccionar_posts_solo_de_la_etiqueta_clickeada()
  {
    // $this->tags[0]->id $this->tags[1]->id
    $this->get('/')
      ->assertSeeLivewire('posts.show-card-post', ['post'=>$this->post, 'indice'=> 0])
      ->assertDontSeeLivewire('follow-model',['tag' => $this->tags[0]] )
      ->assertDontSeeLivewire('follow-model',['tag' => $this->tags[1]] );
      
    Livewire::test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('etiqueta',$this->tags[0]->id)
      ->assertEmitted('askEtiqueta',$this->tags[0]->id);

    Livewire::test('posts.show-index-post')
      ->call('askEtiqueta',$this->tags[0]->id)
      ->assertSee('Etiqueta')
      ->assertSee($this->tags[0]->name)
      ->assertPayloadSet('type', 'Etiqueta');

    Livewire::test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('etiqueta',$this->tags[1]->id)
      ->assertEmitted('askEtiqueta',$this->tags[1]->id);

    Livewire::test('posts.show-index-post')
      ->call('askEtiqueta',$this->tags[1]->id)
      ->assertSee('Etiqueta')
      ->assertSee($this->tags[1]->name)
      ->assertPayloadSet('type', 'Etiqueta');
  }

  /* 
  **
  ** Test de usuario registrado 
  **
  */
  public function test_usuario_registrado_ve_la_imagen_por_default_del_post_cuando_este_no_tiene_una_definida()
  {
    $this->post->image->delete();
    $response = $this->actingAs($this->user)->get('/');
    $response->assertStatus(200);

    $responseStr = $response->__toString();
    $this->assertFalse(strpos($responseStr, 'alt="imagen_post-'.$this->post->id.'"') > 0);
    $this->assertTrue(strpos($responseStr, 'alt="imagen_default-'.$this->post->id.'"') > 0);
    Storage::disk('public')->assertExists('/img-default/post-default.webp');
  }
  public function test_usuario_registrado_ve_la_imagen_del_post_cuando_este_tiene_una_definida()
  {
    $response = $this->actingAs($this->user)->get('/');
    $response->assertStatus(200);

    $responseStr = $response->__toString();
    $this->assertTrue(strpos($responseStr, 'alt="imagen_post-'.$this->post->id.'"') > 0);
    $this->assertFalse(strpos($responseStr, 'alt="imagen_default-'.$this->post->id.'"') > 0);
    Storage::disk('public')->assertExists($this->post->image->url);
  }
  public function test_useario_registrado_pueden_ver_el_nombre_del_post()
  {
    $response = $this->actingAs($this->user)->get('/');
    $response->assertStatus(200);
    $response->assertSee($this->post->name);
  }

  public function test_usuario_registrado_pueden_ver_el_autor_del_post()
  {
    $response = $this->actingAs($this->user)->get('/');

    $response->assertSee($this->autor->name);
  }

  public function test_usuario_registrado_pueden_ver_la_categoria_del_post()
  {
    $response = $this->actingAs($this->user)->get('/');

    $response->assertSee($this->categoria->name);
  }

  public function test_usuario_registrado_pueden_ver_las_etiquetas_del_post()
  {
    $response = $this->actingAs($this->user)->get('/');
    $response->assertSee($this->tags[0]->name);
    $response->assertSee($this->tags[1]->name);
  }

  public function test_usuario_registrado_pueden_ver_la_fecha_de_publicacion_del_post()
  {
    $response = $this->actingAs($this->user)->get('/');

    $response->assertSee(Carbon::parse($this->post->publicar)->format('j F, Y'));
  }

  public function test_usaurio_registrado_pueden_ver_el_extracto_del_post()
  {
    $response = $this->actingAs($this->user)->get('/');

    $response->assertSee($this->post->extract);
  }

  public function test_usuario_registrado_pueden_ver_etiqueta_nuevo_del_post()
  {
    $response = $this->actingAs($this->user)->get('/');

    if (strtotime($this->post->publicar) == strtotime(today())) {
      $response->assertSee('¡Nuevo!');
    }
  }

  public function test_usuario_registrado_no_pueden_ver_etiqueta_nuevo_del_post_si_se_publico_ayer()
  {
    $this->post->update(['publicar' => date('Y/m/d', strtotime("-1 days"))]);

    $response = $this->actingAs($this->user)->get('/');

    $response->assertDontSee('¡Nuevo!');
  }

  public function test_usuario_registrado_puede_ver_componente_bookmark_en_el_post()
  {
    $this->actingAs($this->user)->get('/')->assertSeeLivewire('bookmark-card-post');
    
  }

  public function test_autor_del_post_no_puede_ver_componente_bookmark_en_su_post()
  {
    $this->actingAs($this->autor)->get('/')->assertDontSeeLivewire('bookmark-card-post');
    
  }

  public function test_usuario_registrado_que_selecciono_un_post_puede_ver_seleccionado_el_icono_bookmark_del_post()
  {
    $this->assertTrue(Bookmark::has($this->post,$this->user)); // el usuario eligio este post

    $this->actingAs($this->user)->get('/')->assertSeeLivewire('bookmark-card-post'); // usuario registrado ve el componente

    Livewire::actingAs($this->user)
      ->test('bookmark-card-post', ['post'=> $this->post])
      ->assertSeeHtml('alt="bookmark_select"');
  }

  public function test_usuario_registrado_que_no_selecciono_un_post_puede_ver_no_seleccionado_el_icono_bookmark_del_post()
  {
    $this->assertFalse(Bookmark::has($this->post,$this->editor)); // el editor no eligio este post

    $this->actingAs($this->user)->get('/')->assertSeeLivewire('bookmark-card-post'); // usuario registrado ve el componente

    Livewire::actingAs($this->editor)
      ->test('bookmark-card-post', ['post'=> $this->post])
      ->assertSeeHtml('alt="bookmark_unselect"');
  }

  public function test_usuario_registrado_que_guardo_post_lo_deselecciona()
  {
    $this->assertTrue(Bookmark::has($this->post,$this->user)); // el usuario eligio este post

    $this->actingAs($this->user)->get('/')->assertSeeLivewire('bookmark-card-post'); // usuario registrado ve el componente

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

    $this->actingAs($this->editor)->get('/')->assertSeeLivewire('bookmark-card-post'); // usuario registrado ve el componente

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

  public function test_usuario_registrado_puede_ver_reacciones_asignadas_al_post()
  {
    $this->actingAs($this->user)->get('/')
      ->assertSeeLivewire('show-reaction-post', ['post' => $this->post]);

    $registro = DB::table('markable_reactions')->first();
    $reaccion = $registro->value;
    Livewire::test('show-reaction-post', ['post' => $this->post])
      ->assertPayloadSet($reaccion, 1)
      ->assertSee(1);
  }

  public function test_usuario_registrado_seleccionar_posts_solo_del_autor_clickeado()
  {
    $this->actingAs($this->user)->get('/')
      ->assertSeeLivewire('posts.show-card-post', ['post'=>$this->post, 'indice'=> 0]);
    Livewire::actingAs($this->user)
      ->test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('autor',$this->post->user)
      ->assertEmitted('askAutor',$this->post->user);

    Livewire::actingAs($this->user)
      ->test('posts.show-index-post')
      ->call('askAutor',$this->post->user)
      ->assertSee('Autor')
      ->assertSee($this->post->user->name)
      ->assertPayloadSet('type', 'Autor');
  }

  public function test_usuario_registrado_seleccionar_posts_solo_de_la_categoria_clickeada()
  {
    $this->actingAs($this->user)->get('/')
      ->assertSeeLivewire('posts.show-card-post', ['post'=>$this->post, 'indice'=> 0]);
    Livewire::actingAs($this->user)
      ->test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('categoria',$this->post->categoria->id)
      ->assertEmitted('askCategoria',$this->post->categoria->id);

    Livewire::actingAs($this->user)
      ->test('posts.show-index-post')
      ->call('askCategoria',$this->post->categoria->id)
      ->assertSee('Categoria')
      ->assertSee($this->post->categoria->name)
      ->assertPayloadSet('type', 'Categoria');
  }

  public function test_usuario_registrado_seleccionar_posts_solo_de_la_etiqueta_clickeada()
  {
    // $this->tags[0]->id $this->tags[1]->id
    $this->get('/')
      ->assertSeeLivewire('posts.show-card-post', ['post'=>$this->post, 'indice'=> 0]);
      
    Livewire::actingAs($this->user)
      ->test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('etiqueta',$this->tags[0]->id)
      ->assertEmitted('askEtiqueta',$this->tags[0]->id);

    Livewire::actingAs($this->user)
      ->test('posts.show-index-post')
      ->call('askEtiqueta',$this->tags[0]->id)
      ->assertSee('Etiqueta')
      ->assertSee($this->tags[0]->name)
      ->assertPayloadSet('type', 'Etiqueta');

    Livewire::actingAs($this->user)
      ->test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('etiqueta',$this->tags[1]->id)
      ->assertEmitted('askEtiqueta',$this->tags[1]->id);

    Livewire::actingAs($this->user)
      ->test('posts.show-index-post')
      ->call('askEtiqueta',$this->tags[1]->id)
      ->assertSee('Etiqueta')
      ->assertSee($this->tags[1]->name)
      ->assertPayloadSet('type', 'Etiqueta');
  }

  public function test_usuario_registrado_selecciona_autor_y_lo_sigue()
  {
    $this->assertFalse(Favorite::has($this->autor,$this->user)); //el usuario registrado no sigue al autor del post
    $this->actingAs($this->user)
      ->get('/posts/misposts/4')
      ->assertSee('No hay posts para ver'); //No hay post para ver en Mis autores del usuario registrado

    $this->actingAs($this->user)->get('/')
      ->assertSeeLivewire('posts.show-card-post', ['post'=>$this->post, 'indice'=> 0]);

    Livewire::actingAs($this->user)
      ->test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('autor',$this->post->user)
      ->assertEmitted('askAutor',$this->post->user);

    Livewire::actingAs($this->user)
      ->test('posts.show-index-post')
      ->call('askAutor',$this->post->user)
      ->assertSee('Autor')
      ->assertSee($this->autor->name)
      ->assertPayloadSet('type', 'Autor')
      ->assertSeeLivewire('follow-model',['user' => $this->autor])
      ->assertSeeHtml('alt="fav_autor_unselect"');

    Livewire::actingAs($this->user) 
      ->test('follow-model',['user' => $this->autor])
      ->call('user_like')
      ->assertSeeHtml('alt="fav_autor_select"');

    $this->assertTrue(Favorite::has($this->autor,$this->user)); //el usuario registrado sigue al autor del post
    $this->actingAs($this->user)
      ->get('/posts/misposts/4')
      ->assertSee($this->post->name); //El post del autor seguido, es visible para el usuario registrado

  }
  public function test_usuario_registrado_selecciona_categoria_y_lo_sigue()
  {
    $this->assertFalse(Favorite::has($this->categoria,$this->user)); //el usuario registrado no sigue la categoria del post
    $this->actingAs($this->user)
      ->get('/posts/misposts/2')
      ->assertSee('No hay posts para ver'); //No hay post para ver en Mis categorias del usuario registrado

    $this->actingAs($this->user)->get('/')
      ->assertSeeLivewire('posts.show-card-post', ['post'=>$this->post, 'indice'=> 0]);

    Livewire::actingAs($this->user)
      ->test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('categoria',$this->post->categoria->id)
      ->assertEmitted('askCategoria',$this->post->categoria->id);

    Livewire::actingAs($this->user)
      ->test('posts.show-index-post')
      ->call('askCategoria',$this->post->categoria->id)
      ->assertSee('Categoria')
      ->assertSee($this->post->categoria->name)
      ->assertPayloadSet('type', 'Categoria')
      ->assertSeeLivewire('follow-model',['categoria' => $this->post->categoria])
      ->assertSeeHtml('alt="fav_categoria_unselect"');

    Livewire::actingAs($this->user) 
      ->test('follow-model',['categoria' =>  $this->post->categoria])
      ->call('categoria_like')
      ->assertSeeHtml('alt="fav_categoria_select"');

    $this->assertTrue(Favorite::has($this->post->categoria,$this->user)); //el usuario registrado sigue la categoria del post
    $this->actingAs($this->user)
      ->get('/posts/misposts/2')
      ->assertSee($this->post->categoria->name); //La categoria del post es visible para el usuario registrado
  }
  public function test_usuario_registrado_selecciona_etiqueta_y_lo_sigue()
  {
    $this->assertFalse(Favorite::has($this->tags[0],$this->user)); //el usuario registrado no sigue la etiqueta del post
    $this->actingAs($this->user)
      ->get('/posts/misposts/3')
      ->assertSee('No hay posts para ver'); //No hay post para ver en Mis etiquetas del usuario registrado

    $this->actingAs($this->user)->get('/')
      ->assertSeeLivewire('posts.show-card-post', ['post'=>$this->post, 'indice'=> 0]);

    Livewire::actingAs($this->user)
      ->test('posts.show-card-post',['post'=>$this->post, 'indice'=> 0])
      ->call('etiqueta',$this->tags[0]->id)
      ->assertEmitted('askEtiqueta',$this->tags[0]->id);

    Livewire::actingAs($this->user)
      ->test('posts.show-index-post')
      ->call('askEtiqueta',$this->tags[0]->id)
      ->assertSee('Etiqueta')
      ->assertSee($this->tags[0]->name)
      ->assertPayloadSet('type', 'Etiqueta')
      ->assertSeeLivewire('follow-model',['tag' => $this->tags[0]])
      ->assertSeeHtml('alt="fav_tag_unselect"');

    Livewire::actingAs($this->user) 
      ->test('follow-model',['tag' =>  $this->tags[0]])
      ->call('tag_like')
      ->assertSeeHtml('alt="fav_tag_select"');

    $this->assertTrue(Favorite::has($this->tags[0],$this->user)); //el usuario registrado sigue la etiqueta del post
    $this->actingAs($this->user)
      ->get('/posts/misposts/3')
      ->assertSee($this->tags[0]->name); //La etiqueta del post es visible para el usuario registrado

  }
  public function test_usuario_registrado_barra_de_consulta()
  {

  }
  public function test_usuario_registrado_accede_a_ver_el_post_completo()
  {
    $this->actingAs($this->user)->get('/posts/' . $this->post->slug)
            ->assertStatus(200);
  }
}
