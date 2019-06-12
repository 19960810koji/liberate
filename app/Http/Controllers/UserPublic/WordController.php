<?php

namespace App\Http\Controllers\UserPublic;

use App\Word;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WordController extends Controller {

    public function index() {
        $words = \DB::table('words')->get(['id', 'word']);
        return $words;
    }
    
}
