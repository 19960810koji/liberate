<?php

// APIのURL以外のリクエストに対してはindexテンプレートを返す
Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');
