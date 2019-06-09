<?php

namespace App\Http\Controllers\UserPublic;

use App\User;
use App\Definition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitDefinition;
use Illuminate\Support\Facades\Storage;

class DefinitionController extends Controller {

    public function __construct() {
        $this->middleware('auth')->except(['index']);
    }

    public function index() {
        // $definitions = Definition::with(['owner'])
        //     ->orderBy(Definition::CREATED_AT, 'desc')->paginate();

        // return $definitions;
    }


    public function create(SubmitDefinition $request) {
        $definition = new Definition;
        $definition->word_id = $request->word_id;
        $definition->definition = $request->definition;

        DB::beginTransaction();

        try {
            Auth::user()->definitions()->save($definition);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return response($definition, 201);
    }
}