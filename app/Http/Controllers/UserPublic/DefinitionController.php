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
        $this->middleware('auth')->except(['index', 'detail']);
    }

    public function index() {
        $definitions = Definition::with(['contributor', 'word', 'likes'])
            ->orderBy(Definition::CREATED_AT, 'desc')->paginate();
        
        return $definitions;
    }

    public function detail(int $id) {
        $definition = Definition::where('id', $id)->with(['contributor', 'word', 'likes'])->first();
        return $definition ?? abort(404);
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

    public function like(int $id) {
        $definition = Definition::where('id', $id)->with('likes')->first();
        if(!$definition) return abort(404);

        $definition->likes()->detach(Auth::user()->id);
        $definition->likes()->attach(Auth::user()->id);

        return ['photo_id' => $id];
    }

    public function deleteLike(int $id) {
        $definition = Definition::where('id', $id)->with('likes')->first();
        if(!$definition) abort(404);

        $definition->likes()->detach(Auth::user()->id);

        return ['definition_id' => $id];
    }
}
