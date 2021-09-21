<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    State::create([
      'name' => 'Borrador',
      'color' => 'text-white bg-primary'
    ]);
    State::create([
      'name' => 'Edición',
      'color' => 'text-dark bg-warning'
    ]);
    State::create([
      'name' => 'Programación',
      'color' => 'text-dark bg-danger'
    ]);
    State::create([
      'name' => 'Calendario',
      'color' => 'text-dark bg-info'
    ]);
    State::create([
      'name' => 'Publicado',
      'color' => 'text-white bg-success'
    ]);
    State::create([
      'name' => 'Pausado',
      'color' => 'text-white bg-secondary'
    ]);
    State::create([
      'name' => 'Finalizado',
      'color' => 'text-white bg-dark'
    ]);
  }
}
