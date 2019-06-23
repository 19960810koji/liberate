<?php

namespace App\Http\Controllers\UserPublic;

use App\User;
use App\Like;
use App\Word;
use App\Definition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller {
    
    public function index(int $id) {
        $user = User::where('id', $id)->with(['definitions'])->first();

        return $user;
    }
}
