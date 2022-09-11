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
      'id' => 1,
      'name' => 'Borrador',
      'color' => 'text-white bg-primary'
    ]);
    State::create([
      'id' => 2,
      'name' => 'Edición',
      'color' => 'text-dark bg-warning'
    ]);
    State::create([
      'id' => 3,
      'name' => 'Programación',
      'color' => 'text-dark bg-danger'
    ]);
    State::create([
      'id' => 4,
      'name' => 'Calendario',
      'color' => 'text-dark bg-info'
    ]);
    State::create([
      'id' => 5,
      'name' => 'Publicado',
      'color' => 'text-white bg-success'
    ]);
    State::create([
      'id' => 6,
      'name' => 'Pausado',
      'color' => 'text-white bg-secondary'
    ]);
    State::create([
      'id' => 7,
      'name' => 'Finalizado',
      'color' => 'text-white bg-dark'
    ]);
  }
}
