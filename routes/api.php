<?php

use Illuminate\Http\Request;

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');
// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');
// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// 定義投稿
Route::post('/definitions', 'UserPublic\DefinitionController@create')->name('definition.create');
// 定義一覧
Route::get('/definitions', 'UserPublic\DefinitionController@index')->name('definition.index');
// 定義詳細
Route::get('/definitions/{id}', 'UserPublic\DefinitionController@detail')->name('definition.detail');
// いいね
Route::put('/definitions/{id}/like', 'UserPublic\DefinitionController@like')->name('definition.like');
// いいね解除
Route::delete('/definitions/{id}/like', 'UserPublic\DefinitionController@deleteLike');

// 単語一覧
Route::get('/words', 'UserPublic\WordController@index')->name('word.index');

Route::get('/user', function () {
    return Auth::user();
})->name('user');

// トークンをリフレッシュ
Route::get('/reflesh-token', function(Illuminate\Http\Request $request) {
    $request->session()->regenerateToken();
    return response()->json();
});