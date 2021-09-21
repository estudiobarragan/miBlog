<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Notas de aprendizaje

### Trabajar con emails

Configurar una una cuenta con mailtrap y colocar credenciales en el archivo .env. Posteriormente es necesario generar un archivo maileable el cual servira para generar la vista donde se enviara la informacion por mail. Para ello se debe utilizar el comando:

-   php artisan make:mail ApprovedPost
    Esto generara en la carpeta mail, un archivo ApprovedPost.php. Alli se parametrizara el contenido que luego la vista va a tomar. Una comando para esto seria en la funcion build():
-   return $this->view('mail.approved-post')->subject('Curso aprovado');
    Aca vemos que el subject del mail lo podemos cargar ahi. Si quisieramos que la vista tenga variables, por ejemplo $post, se deben generar las variables publicas:
-   public $post
    En el constructor, se colocaria:

-   public function \_\_construct(Post $post)
-   $this->post = $post;

Con esto la vista tendria disponible la variable $post. Esta vista, se puede genear con ! y enter y se diseñara segun el gusto del que envia. Para enviar se puede ir al controlador:

-   $mail = new ApprovedPost($post);
-   Mail::to($course->teacher->email)->send($mail); opcionalmente
-   Mail::to($course->teacher->email)->queue($mail);

### Trabajar con colas

Para el trabajo con colas, primeramente es necesario configurar la variable de ambiente QUEUE_CONNECTION y pasarla de su estado sync (que envia al momento el correo) por database. Esto significa que comenzara a grabarse en una tabla llamada job. Luego es necesario ejecutar:

-   php artisan queue:table
-   php artisan migrate

Luego es necesario ir al controlador donde se enviaba el correo y cambiar:
Mail::to($post->user->email)->send($mail) por
Mail::to($post->user->email)->queue($mail)

Para ejecutar las colas que esten pendientes debo ejecutar

php artisan queue:work

Hecho esto, se quedara escuchando a la espera de un nuevo job.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
