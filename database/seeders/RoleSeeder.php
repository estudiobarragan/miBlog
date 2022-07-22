<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $role1 = Role::create([
      'name' => 'Admin'
    ]);
    $role2 = Role::create([
      'name' => 'Autor'
    ]);
    $role3 = Role::create([
      'name' => 'Editor'
    ]);
    $role4 = Role::create([
      'name' => 'Publicador'
    ]);
    $role5 = Role::create([
      'name' => 'Lector'
    ]);

    Permission::create([
      'name' => 'admin.home',
      'description' => 'Ver panel de administrador'
    ])->syncRoles([$role1, $role2, $role3, $role4]);

    Permission::create([
      'name' => 'admin.users.index',
      'description' => 'Ver listado de usuarios'
    ])->syncRoles([$role1, $role3, $role4]);

    Permission::create([
      'name' => 'admin.users.edit',
      'description' => 'Editar roles de usuarios'
    ])->syncRoles([$role1]);

    Permission::create([
      'name' => 'admin.categories.index',
      'description' => 'Ver listado de categorias'
    ])->syncRoles([$role1, $role2, $role3, $role4]);
    Permission::create([
      'name' => 'admin.categories.create',
      'description' => 'Crear categorias'
    ])->syncRoles([$role1]);
    Permission::create([
      'name' => 'admin.categories.edit',
      'description' => 'Editar categoria'
    ])->syncRoles([$role1]);
    Permission::create([
      'name' => 'admin.categories.destroy',
      'description' => 'Eliminar categoria'
    ])->syncRoles([$role1]);

    Permission::create([
      'name' => 'admin.tags.index',
      'description' => 'Ver listado de etiquetas'
    ])->syncRoles([$role1, $role2, $role3, $role4]);
    Permission::create([
      'name' => 'admin.tags.create',
      'description' => 'Crear etiqueta'
    ])->syncRoles([$role1]);
    Permission::create([
      'name' => 'admin.tags.edit',
      'description' => 'Editar etiqueta'
    ])->syncRoles([$role1]);
    Permission::create([
      'name' => 'admin.tags.destroy',
      'description' => 'Eliminar etiqueta'
    ])->syncRoles([$role1]);

    Permission::create([
      'name' => 'admin.posts.index',
      'description' => 'Ver listado de post'
    ])->syncRoles([$role1, $role2]);
    Permission::create([
      'name' => 'admin.posts.create',
      'description' => 'Crear un post'
    ])->syncRoles([$role2]);
    Permission::create([
      'name' => 'admin.posts.edit',
      'description' => 'Editar un post'
    ])->syncRoles([$role2]);
    Permission::create([
      'name' => 'admin.posts.destroy',
      'description' => 'Eliminar un post'
    ])->syncRoles([$role2]);

    Permission::create([
      'name' => 'admin.roles.index',
      'description' => 'Ver listado de roles'
    ])->syncRoles([$role1]);
    Permission::create([
      'name' => 'admin.roles.create',
      'description' => 'Crear un rol'
    ])->syncRoles([$role1]);
    Permission::create([
      'name' => 'admin.roles.edit',
      'description' => 'Editar un rol'
    ])->syncRoles([$role1]);
    Permission::create([
      'name' => 'admin.roles.destroy',
      'description' => 'Eliminar un rol'
    ])->syncRoles([$role1]);

    Permission::create([
      'name' => 'admin.approves.index',
      'description' => 'Ver listado de post a aprobar'
    ])->syncRoles([$role1, $role3]);
    Permission::create([
      'name' => 'admin.approves.create',
      'description' => 'Crear aprobación para post'
    ])->syncRoles([$role3]);
    Permission::create([
      'name' => 'admin.approves.edit',
      'description' => 'Editar y actualizar  aprobación para post'
    ])->syncRoles([$role3]);
    Permission::create([
      'name' => 'admin.approves.show',
      'description' => 'Mostrar aprobación para post'
    ])->syncRoles([$role3]);
    Permission::create([
      'name' => 'admin.approves.reject',
      'description' => 'Rechazar post en edicion'
    ])->syncRoles([$role3]);

    Permission::create([
      'name' => 'admin.publication.index',
      'description' => 'Ver listado de post a programar'
    ])->syncRoles([$role1, $role4]);
    Permission::create([
      'name' => 'admin.publication.create',
      'description' => 'Definir fecha de publicacion del post'
    ])->syncRoles([$role4]);
    Permission::create([
      'name' => 'admin.publication.edit',
      'description' => 'Modificar fecha de publicacion de un post'
    ])->syncRoles([$role4]);
    Permission::create([
      'name' => 'admin.publication.show',
      'description' => 'Mostrar fecha de publicacion de post'
    ])->syncRoles([$role4]);
    Permission::create([
      'name' => 'admin.publication.pause',
      'description' => 'Pausar post -no visible / visible-'
    ])->syncRoles([$role1]);
    Permission::create([
      'name' => 'admin.publication.destroy',
      'description' => 'Invisibilizar post'
    ])->syncRoles([$role1]);
  }
}
