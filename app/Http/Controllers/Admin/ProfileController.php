<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $profile = auth()->user()->profile;
    if (isset($profile)) {
      return redirect()->route('admin.profile.edit', ['profile' => $profile]);
    }

    return view('admin.profile.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(ProfileRequest $request)
  {
    if (!isset(auth()->user()->profile)) {
      $profile = Profile::create([
        'user_id' => auth()->user()->id,
        'title' => $request->title,
        'website' => $request->website,
        'biografia' => $request->biografia,
        'telegram' => $request->telegram,
        'facebook' => $request->facebook,
        'instagram' => $request->instagram,
        'twitter' => $request->twitter,
        'tiktok' => $request->tiktok,
      ]);
    }
    return redirect()->route('admin.profile.edit', ['profile' => $profile])->with('success', 'El perfil se creo con exito');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Profile  $profile
   * @return \Illuminate\Http\Response
   */
  public function show(Profile $profile)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Profile  $profile
   * @return \Illuminate\Http\Response
   */
  public function edit(Profile $profile)
  {
    $profile = auth()->user()->profile;

    return view('admin.profile.edit', compact('profile'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Profile  $profile
   * @return \Illuminate\Http\Response
   */
  public function update(ProfileRequest $request, Profile $profile)
  {
    $profile->update([
      'user_id' => auth()->user()->id,
      'title' => $request->title,
      'website' => $request->website,
      'biografia' => $request->biografia,
      'telegram' => $request->telegram,
      'facebook' => $request->facebook,
      'instagram' => $request->instagram,
      'twitter' => $request->twitter,
      'tiktok' => $request->tiktok,
    ]);

    return redirect()->route('admin.profile.edit', ['profile' => $profile])->with('success', 'El perfil se actualizo con exito');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Profile  $profile
   * @return \Illuminate\Http\Response
   */
  public function destroy(Profile $profile)
  {
    //
  }
}
