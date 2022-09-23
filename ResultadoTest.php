λ php artisan test
Warning: TTY mode is not supported on Windows platform.

   PASS  Tests\Feature\AuthTest
  ✓ new user appear after login
  ✓ user can login with correct credentials
  ✓ user cannot login with incorrect password
  ✓ usuario no autorizado acceda a mis post
  ✓ usuario no autorizado acceda a mis categorias
  ✓ usuario no autorizado acceda a mis etiquetas
  ✓ usuario no autorizado acceda a mis autores
  ✓ usuario no autorizado acceda a proximos

   PASS  Tests\Feature\HomeFeatureTest
  ✓ guess ve la imagen por default del post cuando este no tiene una definida
  ✓ guess ve la imagen del post cuando este tiene una definida
  ✓ guess pueden ver el nombre del post
  ✓ guess pueden ver el autor del post
  ✓ guess pueden ver la categoria del post
  ✓ guess pueden ver las etiquetas del post
  ✓ guess pueden ver la fecha de publicacion del post
  ✓ guess pueden ver el extracto del post
  ✓ guess pueden ver etiqueta nuevo del post
  ✓ guess no pueden ver etiqueta nuevo del post si se publico ayer
  ✓ guess no puede ver componente bookmark en el post
  ✓ guess puede ver componente likes en el post
  ✓ guess puede ver un like asignado al post
  ✓ guess no puede ver reacciones asignadas al post
  ✓ guess accede a ver el post completo
  ✓ guess seleccionar posts solo del autor clickeado
  ✓ guess seleccionar posts solo de la categoria clickeada
  ✓ guess seleccionar posts solo de la etiqueta clickeada
  ✓ guess ve la barra de consulta
  ✓ guess busca post satisfactoriamente
  ✓ usuario registrado ve la imagen por default del post cuando este no tiene una definida
  ✓ usuario registrado ve la imagen del post cuando este tiene una definida
  ✓ useario registrado pueden ver el nombre del post
  ✓ usuario registrado pueden ver el autor del post
  ✓ usuario registrado pueden ver la categoria del post
  ✓ usuario registrado pueden ver las etiquetas del post
  ✓ usuario registrado pueden ver la fecha de publicacion del post
  ✓ usaurio registrado pueden ver el extracto del post
  ✓ usuario registrado pueden ver etiqueta nuevo del post
  ✓ usuario registrado no pueden ver etiqueta nuevo del post si se publico ayer
  ✓ usuario registrado puede ver componente bookmark en el post
  ✓ usuario registrado que selecciono un post puede ver seleccionado el icono bookmark del post
  ✓ usuario registrado que no selecciono un post puede ver no seleccionado el icono bookmark del post
  ✓ usuario registrado que guardo post lo deselecciona
  ✓ usuario registrado que no guardo post lo selecciona
  ✓ usuario registrado que guardo post lo ve en post guardado
  ✓ usuario registrado que no guardo post no ve el post como guardado
  ✓ usuario registrado puede ver reacciones asignadas al post
  ✓ usuario registrado seleccionar posts solo del autor clickeado
  ✓ usuario registrado seleccionar posts solo de la categoria clickeada
  ✓ usuario registrado seleccionar posts solo de la etiqueta clickeada
  ✓ usuario registrado selecciona autor y lo sigue
  ✓ usuario registrado selecciona categoria y lo sigue
  ✓ usuario registrado selecciona etiqueta y lo sigue
  ✓ usuario registrado ve la barra de consulta
  ✓ usuario registrado ve proximos post a ser publicados
  ✓ usuario registrado accede a ver el post completo
  ✓ usuario registrado busca post satisfactoriamente
  ✓ el autor no puede ver y o acceder a reacciones a su post
  ✓ el autor no puede seguirse a si mismo
  ✓ el autor del post no puede ver componente bookmark en su post
  ✓ el usuario registrado puede ver su foto al lado de la campana de notificacion

   PASS  Tests\Feature\HomePostPageTest
  ✓ guess accede a ver el post completo
  ✓ guess ve la imagen por default del post cuando este no tiene una definida
  ✓ guess ve la imagen del post cuando este tiene una definida
  ✓ guess pueden ver el nombre del post
  ✓ guess pueden ver el autor del post
  ✓ guess pueden ver el correo electronico del autor del post
  ✓ guess pueden ver el rol del autor del post
  ✓ guess pueden ver la foto del autor del post
  ✓ guess pueden ver la foto de default del autor del post si este no tiene una
  ✓ guess no puede ver el componente de seguimiento del autor del post
  ✓ guess puede ver componente show profile del autor del post si definio su perfil
  ✓ guess puede ver post relacionados de igual categoria que el post elegido
  ✓ guess no puede ver componente show profile del autor del post sino definio su perfil
  ✓ guess pueden ver la categoria del post
  ✓ guess pueden ver las etiquetas del post
  ✓ guess pueden ver la fecha de publicacion del post
  ✓ guess pueden ver el extracto del post
  ✓ guess pueden ver el body del post
  ✓ guess pueden ver etiqueta nuevo del post
  ✓ guess no pueden ver etiqueta nuevo del post si se publico ayer
  ✓ guess no puede ver componente de reaccion al post
  ✓ guess no puede ver componente bookmark en el post
  ✓ guess el post no se ve imagen y similares muestran default
  ✓ guess el post se borra fisicamente la imagen
  ✓ usuario registrado accede a ver el post completo
  ✓ usuario registrado ve la imagen por default del post cuando este no tiene una definida
  ✓ usuario registrado ve la imagen del post cuando este tiene una definida
  ✓ usuario registrado pueden ver el nombre del post
  ✓ usuario registrado pueden ver el autor del post
  ✓ usuario registrado pueden ver el correo electronico del autor del post
  ✓ usuario registrado pueden ver el rol del autor del post
  ✓ usuario registrado pueden ver la foto del autor del post
  ✓ usuario registrado pueden ver la foto de default del autor del post si este no tiene una
  ✓ usuario registrado puede ver el componente de seguimiento del autor del post
  ✓ usuario registrado puede ver componente show profile del autor del post si definio su perfil
  ✓ usuario registrado puede ver post relacionados de igual categoria que el post elegido
  ✓ usuario registrado no puede ver componente show profile del autor del post sino definio su perfil
  ✓ usuario registrado pueden ver la categoria del post
  ✓ usuario registrado pueden ver las etiquetas del post
  ✓ usuario registrado pueden ver la fecha de publicacion del post
  ✓ usuario registrado pueden ver el extracto del post
  ✓ usuario registrado pueden ver el body del post
  ✓ usuario registrado pueden ver etiqueta nuevo del post
  ✓ usuario registrado no pueden ver etiqueta nuevo del post si se publico ayer
  ✓ usuario registrado puede ver componente de reaccion al post
  ✓ usuario registrado ve reaccion elegida en el post
  ✓ usuario registrado cambia reaccion elegida en el post satisfactoriamente
  ✓ usuario registrado agrega reacciones positivas y negativas en el post satisfactoriamente
  ✓ usuario registrado puede ver componente bookmark en el post
  ✓ usuario registrado que selecciono un post puede ver seleccionado el icono bookmark del post
  ✓ usuario registrado que no selecciono un post puede ver no seleccionado el icono bookmark del post
  ✓ usuario registrado que guardo post lo deselecciona
  ✓ usuario registrado que no guardo post lo selecciona
  ✓ usuario registrado que guardo post lo ve en post guardado
  ✓ usuario registrado que no guardo post no ve el post como guardado
  ✓ usuario registrado elige seguir al autor del post

   PASS  Tests\Feature\PagesAccessTest
  ✓ acceso guest a la pagina principal
  ✓ guest en la pagina principal tiene login
  ✓ guest en la pagina principal tiene registrar
  ✓ usuario no registrado no ve opcion mis post
  ✓ usuario no registrado no ve opcion mis categorias
  ✓ usuario no registrado no ve opcion mis etiquetas
  ✓ usuario no registrado no ve opcion mis autores
  ✓ usuario no registrado no ve opcion proximos
  ✓ usuario registrado tiene opcion mis post
  ✓ usuario registrado tiene opcion mis categorias
  ✓ usuario registrado tiene opcion mis etiquetas
  ✓ usuario registrado tiene opcion mis autores
  ✓ usuario registrado tiene opcion proximos
  ✓ acceso usuario registrado a la pagina mis post
  ✓ acceso usuario registrado a la pagina mis categorias
  ✓ acceso usuario registrado a la pagina mis etiquetas
  ✓ acceso usuario registrado a la pagina mis autores
  ✓ acceso usuario registrado a la pagina proximos posts
  ✓ acceso guest a la pagina login
  ✓ acceso guest a la pagina registro

   WARN  Tests\Feature\RegistrationTest
  ✓ registration screen can be rendered
  - registration screen cannot be rendered if support is disabled → Registration support is enabled.
  ✓ new users can register

  Tests:  1 skipped, 138 passed
  Time:   141.58s