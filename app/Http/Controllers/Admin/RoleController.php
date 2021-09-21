<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
  public function  __construct()
  {
    $this->middleware('can:admin.roles.index')->only('index');
    $this->middleware('can:admin.roles.edit')->only('edit', 'update');
    $this->middleware('can:admin.roles.create')->only('create', 'store');
    $this->middleware('can:admin.roles.destroy')->only('destroy');
  }
  public function index()
  {
    $roles = Role::all();
    return view('admin.roles.index', compact('roles'));
  }


  public function create()
  {
    $permissions = Permission::all();
    return view('admin.roles.create', compact('permissions'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|unique:roles',
    ]);

    $role = Role::create($request->all());
    $role->permissions()->sync($request->permissions);

    $roles = Role::all();
    return redirect()->route('admin.roles.index', compact('roles'))->with('success', 'El rol se creo con exito');
  }

  public function edit(Role $role)
  {
    $permissions = Permission::all();
    return view('admin.roles.edit', compact('role', 'permissions'));
  }


  public function update(Request $request, Role $role)
  {
    $request->validate([
      'name' => "required|unique:roles,name,$role->id",
    ]);
    $role->update($request->all());
    $role->permissions()->sync($request->permissions);

    $roles = Role::all();
    return redirect()->route('admin.roles.index', compact('roles'))->with('success', 'El rol se actualizo con exito');
  }

  public function destroy(Role $role)
  {
    $role->delete();
    $roles = Role::all();
    return redirect()->route('admin.roles.index', compact('roles'))->with('success', 'El rol se elimino con exito');
  }
}
