<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;


class PublicationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.publication.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    return view('admin.publication.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Publication  $publication
   * @return \Illuminate\Http\Response
   */
  public function show(Publication $publication)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Publication  $publication
   * @return \Illuminate\Http\Response
   */
  public function edit(Publication $publication)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Publication  $publication
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Publication $publication)
  {
    //
  }

  public function destroy(Publication $publication)
  {
    // 
  }
  public function calendario()
  {
    return view('admin.publication.calendario');
  }
}
