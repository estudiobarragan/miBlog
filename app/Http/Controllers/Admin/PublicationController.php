<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
  public function create()
  {
    $aprogramar = Post::where([
      ['state_id', 3],
      ['publicador_id', auth()->user()->id],
      ['user_id', '!=', auth()->user()->id],
    ])
      ->orWhere([
        ['state_id', 3],
        ['publicador_id', null],
        ['user_id', '!=', auth()->user()->id],
      ])
      ->orderBy('id', 'asc')
      ->get();
    $programados = Post::where([
      ['state_id', 4],
      ['publicador_id', auth()->user()->id],
      ['user_id', '!=', auth()->user()->id],
    ])
      ->orderBy('id', 'asc')
      ->get();
    return view('admin.publication.create', compact('aprogramar', 'programados'));
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

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Publication  $publication
   * @return \Illuminate\Http\Response
   */
  public function destroy(Publication $publication)
  {
    //
  }

  public function ajax(Request $request)
  {

    $data = $request->input('data');

    return $data;
    /*  $start = Carbon::createFromFormat('y-m-d', '01/09/2021');
    $end = Carbon::createFromFormat('y-m-d', '30/09/2021');


    $data = Publication::whereDate('dateTo', '>=', $start)
      ->whereDate('end',   '<=', $end)
      ->get(['id', 'title', 'dateTo']);
    return Response::json('algo'); */
  }
  public function ajax_ask(Request $request)
  {
    $start = (!empty($request->input('start'))) ? ($request->input('start')) : ('');
    $end = (!empty($request->input('end'))) ? ($request->input('end')) : ('');

    $data = Publication::where('id', 1)->get();

    /* return Response::json($data); */

    return Response::json([
      [
        "title" => "Event 1",
        "start" => "2021-09-05T09:00:00",
        "end" => "2021-09-05T18:00:00"
      ],
    ]);

    /* if (request()->ajax()) {

      $start = (!empty($request->input('start'))) ? ($request->input('start')) : ('');
      $end = (!empty($request->input('end'))) ? ($request->input('end')) : ('');

      $data = Publication::whereDate('dateTo', '>=', $start)
        ->whereDate('end',   '<=', $end)
        ->get(['id', 'title', 'dateTo']);
      return Response::json($data);

    }

    return $data; */
  }
}
