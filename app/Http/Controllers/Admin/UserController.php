<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  public function  __construct()
  {
    $this->middleware('can:admin.users.index')->only('index');
    $this->middleware('can:admin.users.edit')->only('edit', 'update');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.users.index');
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    $roles = Role::all();
    return view('admin.users.edit', compact('user', 'roles'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {

    if ($user->hasRole('Admin') && !in_array(1, $request->roles)) {
      $adminCount = User::role('admin')->count();
      if ($adminCount == 1) {
        return redirect()->back()->withInput()->withErrors(['roles' => 'No puede eliminar el rol Administrador']);
      }
    }
    $user->roles()->sync($request->roles);

    return redirect()->route('admin.users.index')->with('success', 'Roles actualizados satisfactoriamente');
  }
}
