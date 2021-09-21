<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  public function  __construct()
  {
    $this->middleware('can:admin.categories.index')->only('index');
    $this->middleware('can:admin.categories.edit')->only('edit', 'update');
    $this->middleware('can:admin.categories.create')->only('create', 'store');
    $this->middleware('can:admin.categories.destroy')->only('destroy');
  }

  public function index()
  {
    $categories = Categoria::all();
    return view('admin.categories.index', compact('categories'));
  }

  public function create()
  {
    return view('admin.categories.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'slug' => 'required|unique:categorias'
    ]);
    Categoria::create($request->all());
    return redirect()->route('admin.categories.index')->with('success', 'Categoria agregada satisfactoriamente');
  }


  public function edit(Categoria $category)
  {
    return view('admin.categories.edit', compact('category'));
  }

  public function update(Request $request, Categoria $category)
  {
    $request->validate([
      'name' => 'required',
      'slug' => "required|unique:categorias,slug,$category->id",
    ]);
    $category->update($request->all());

    return redirect()->route('admin.categories.index')->with('success', 'Categoria actualizada satisfactoriamente');
  }

  public function destroy(Categoria $category)
  {
    $category->delete();

    return redirect()->route('admin.categories.index')->with('success', 'Categoria eliminada satisfactoriamente');
  }
}
