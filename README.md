<p align="center"><img src="https://postimg.cc/G9KtwSjv" width="400"></p>

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
