<?php

use App\Http\Controllers\SpiderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

function generator()
{
    for ($i = 0; $i < 10; $i++) {
        yield $i;
    }
}

Route::get('/yield', function () {
    $array = generator();

    dump($array);

    foreach ($array as $value) {

        print_r($value);
    }

    dump($array);
})->name('yield');

Route::group(['prefix' => 'roach', 'as' => 'roach.'], function () {

    // Route::get('/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('admin.dashboard');
    Route::get('GameLinks', [SpiderController::class, 'index'])->name('GameLinks');
});
