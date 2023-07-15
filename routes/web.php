<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserProfile;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

// Tags
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
// Profile
Route::group(['prefix'=>'profile'  , 'as'=>'profile.' ,'middleware'=>'auth'] , function (){
    Route::get('/', [UserProfile::class ,'edit'])
        ->name('edit');

    Route::put('/', [UserProfile::class ,'update'])
        ->name('update');
});


// Answers
Route::group(['prefix'=>'answers'  , 'as'=>'answers.' ,'middleware'=>'auth'] , function (){

    Route::put('/{id}/best', [AnswersController::class, 'bestAnswer'])
        ->name('best');

    Route::post('/', [AnswersController::class ,'store'])
        ->name('store');
    Route::get('{answerId}/edit', [AnswersController::class ,'edit'])
        ->name('edit');
    Route::put('{answerId}', [AnswersController::class ,'update'])
        ->name('update');
    Route::delete('{answerId}', [AnswersController::class ,'destroy'])
        ->name('destroy');

});


// Questions
Route::resource('questions', QuestionsController::class);










require __DIR__.'/auth.php';
