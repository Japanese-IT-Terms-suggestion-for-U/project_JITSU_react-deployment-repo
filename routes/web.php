<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserTagController;
use App\Http\Controllers\UserWordController;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;

if (env('APP_ENV') == 'production') {
    \Illuminate\Support\Facades\URL::forceScheme('https');
}

Route::get('/', function () {
    return view('main');
})->name('main');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [WordController::class, 'index'])
        ->name('dashboard');
    Route::get('/board', [PostController::class, 'show'])
        ->name('board');
    Route::post('/post/comments', [CommentController::class, 'store'])
        ->name('post.comments');
    Route::put('/post/comments/{comment}', [CommentController::class, 'update'])
        ->name('post.comments.update');
    Route::delete('/post/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('post.comments.destroy');
});

Route::post('/words', [WordController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/random-word', [WordController::class, 'random']);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::patch('/user-words/{word}', [UserWordController::class, 'addWordPad'])
        ->name('user-words.update');

    Route::get('/favorite-word', [UserWordController::class, 'getFavoriteWord'])
        ->name('favorite-words');
    Route::get('/unfamiliar-word', [UserWordController::class, 'getUnfamiliarWord'])
        ->name('unfamiliar-words');

    Route::get('/next-favorite-word', [UserWordController::class, 'getNextFavoriteWord'])
        ->name('next-favorite-word');
    Route::get('/next-unfamiliar-word', [UserWordController::class, 'getNextUnfamiliarWord'])
        ->name('next-unfamiliar-word');

    Route::patch('/profile/tags-update', [UserTagController::class, 'update'])
        ->name('profile.tags.update');
    Route::get('/profile/get-user-tags', [UserTagController::class, 'getUserTags'])
        ->name('profile.tags.get');

    Route::get('/word-status/{wordId}', [UserWordController::class, 'getWordStatus'])
        ->name('word-status');
});

require __DIR__ . '/auth.php';