<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\TagsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix'=>'tags'  , 'as'=>'tags.' ,'middleware'=>'auth'] , function (){
    Route::get('', [TagsController::class ,'index'])
        ->name('index');

    Route::get('/create', [TagsController::class ,'create'])
        ->name('create');

    Route::post('', [TagsController::class ,'store'])
        ->name('store');

    Route::get('/{tag_id}/edit', [TagsController::class ,'edit'])
        ->name('edit');

    Route::put('/{id}', [TagsController::class ,'update'])
        ->name('update');

    Route::delete('/{tag_id}', [TagsController::class ,'destroy'])
        ->name('destroy');
});

Route::resource('questions', QuestionsController::class)->middleware('auth');










require __DIR__.'/auth.php';
