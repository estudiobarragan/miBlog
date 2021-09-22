## Aprendizajes con Laravel

### Relaciones entre datos: 1 a 1

En una relacion 1 a 1 Ejemplo User y Profile. Se coloca en los modelos:

en User (1 a 1)
public function profile(){
..return $this->hasOne(Profiles::class);
}

en Profile (1 a 1 inversa)
public function user(){
..return $this->belongTo(User::class);
}

aca se agregara un campo foraneo a Profile

### Relacion 1 a N

Este caso puede ejemplificarse como 1 usuario que tiene muchos post, pero cada post pertenece a un unico usuario. Esto genera una relacion 1 a N

en User (1 a N)
public function posts(){
..return $this->hasMany(Post::class);
}
en Post (1 a N inversa)
public function user(){
..return $this->belongTo(User::class);
}

### Relacion N a N

Este caso se da entre dos entidades donde una puede estar vinculada a varias de la otra entidad y viceversa. Se caracteriza por tener una tabla auxiliar que conecta a ambas entidades. El ejemplo seria Roles y Usuarios. donde un usuario puede tener varios roles y cada rol pertenecer a varios usuarios.

en User (N a N)
public function roles(){
..return $this->belongToMany(Role::class);
}

en Role (N a N inversa)
public function users(){
..return $this->belongToMany(User::class);
}

### Relaciones Polimorficas 1 a 1

Este caso se da cuando una entidad puede tener en su interior registros pertenecientes a un numero indefinido de entidades. Por ejempplo post y user, pueden tener una imagen cada uno. En este caso es una unica base de datos con relacion 1 a 1 con las otras dos entidades.

en Image (polmorfica 1 a 1)
public function imageable(){
..return $this->morphTo();
}

en Post(polimorfica 1 a 1)
public function image(){
..return $this->morphOne(Image::class, 'imageable');
}

en User(polimorfica 1 a 1)
public function image(){
..return $this->morphOne(Image::class, 'imageable');
}

### Relaciones Polimorficas 1 a N

En este caso las relaciones entre la entidad comun imagenes, tienen relacion N a N con Post y videos. Esto es que cada Post puede tener varias imagenes y cada video tener varias imagenes, pero cada imagen pertenece a un unico post o a un unico video.

en Image (polimorfica 1 a N)
public function imageable(){
.. return $this->morphTo();
}
en Post (polmorfica 1 a N Inversa)
public function images(){
..return $this->morphMany(Image::class, 'imageable');
}
en Video (polmorfica 1 a N Inversa)
public function images(){
..return $this->morphMany(Image::class, 'imageable');
}

### Relaciones Polimorficas N a N

Este ejemplo se da con Etiquetas y Post y Videos. Donde cada video o post puede tener varias etiquetas y viceversa.

en Post (polimorfica N a N)
public function tags(){
.. return $this->morphToMany(Tag::class, 'taggable');
}

en Video (polimorfica N a N)
public function tags(){
..return $this->morphToMany(Tag::class, 'taggable');
}

en Tag (polimorfica N a N inversa)
public function posts(){
..return $this->morphedByMany(Post::class, 'taggable');
}
public function videos(){
..return $this->morphedByMany(Video::class, 'taggable');
}
