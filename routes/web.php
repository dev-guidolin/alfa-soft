<?php

use Illuminate\Support\Facades\Route;

Route::resource('/',\App\Http\Controllers\Agenda::class)->names([
    'index'     => 'agenda.index',
    'create'    => 'agenda.create',
    'store'     => 'agenda.store',
    'show'      => 'agenda.show',
    'edit'      => 'agenda.edit',
    'update'    => 'agenda.update',
    'destroy'   => 'agenda.destroy',
]);
