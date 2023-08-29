<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserProfile;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Route::group(['middleware'=>['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] ,'prefix'=> LaravelLocalization::setLocale() ] , function () {

    // Tags
    Route::group(['middleware'=>['auth' ,'checkUserType:admin,super-admin'] , 'prefix' => 'tags', 'as' => 'tags.'], function () {
        Route::get('', [TagsController::class, 'index'])
            ->name('index');

        Route::get('/create', [TagsController::class, 'create'])
            ->name('create');

        Route::post('', [TagsController::class, 'store'])
            ->name('store');

        Route::get('/{tag_id}/edit', [TagsController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [TagsController::class, 'update'])
            ->name('update');

        Route::delete('/{tag_id}', [TagsController::class, 'destroy'])
            ->name('destroy');
    });

    // Profile
    Route::group(['middleware'=>'auth' ,'prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [UserProfile::class, 'edit'])->name('edit');
        Route::put('/', [UserProfile::class, 'update'])->name('update');
    });

    // Change password
    Route::group(['middleware'=>'auth' ,'prefix' => 'password', 'as' => 'password.'], function () {
        Route::get('/change', [ChangePasswordController::class, 'edit'])->name('edit');
        Route::post('/', [ChangePasswordController::class, 'update'])->name('update');
    });

    // Answers
    Route::group(['middleware'=>'auth' ,'prefix' => 'answers', 'as' => 'answers.'], function () {

        Route::put('/{id}/best', [AnswersController::class, 'bestAnswer'])
            ->name('best');

        Route::post('/', [AnswersController::class, 'store'])
            ->name('store');
        Route::get('{answerId}/edit', [AnswersController::class, 'edit'])
            ->name('edit');
        Route::put('{answerId}', [AnswersController::class, 'update'])
            ->name('update');
        Route::delete('{answerId}', [AnswersController::class, 'destroy'])
            ->name('destroy');

    });

    // Questions
    Route::resource('questions', QuestionsController::class);

    // Roles
    Route::resource('roles', RolesController::class);

    // Users
    Route::resource('users', UsersController::class);

    // Notifications
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index')->middleware('auth');
});

Route::get('/', function () {
    return redirect()->route('questions.index');
});











require __DIR__.'/auth.php';
