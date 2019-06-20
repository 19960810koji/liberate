<?php

namespace App\Http\Controllers\UserPublic;

use App\User;
use App\Definition;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComment;
use App\Http\Requests\SubmitDefinition;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class DefinitionController extends Controller {

    public function __construct() {
        $this->middleware('auth')->except(['index', 'detail']);
    }

    /**
     * 投稿一覧
     *
     * @return void
     */
    public function index() {
        $definitions = Definition::with(['contributor', 'word', 'likes'])
            ->orderBy(Definition::CREATED_AT, 'desc')->paginate();
        
        return $definitions;
    }

    /**
     * 投稿詳細
     *
     * @param integer $id
     * @return void
     */
    public function detail(int $id) {
        $definition = Definition::where('id', $id)->with(['contributor', 'word', 'likes', 'comments.author'])->first();
        return $definition ?? abort(404);
    }


    /**
     * 投稿処理
     *
     * @param SubmitDefinition $request
     * @return void
     */
    public function create(SubmitDefinition $request) {
        DB::beginTransaction();

        try {
            $definition = new Definition;
            $definition->word_id = $request->word_id;
            $definition->definition = $request->definition;
            Auth::user()->definitions()->save($definition);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new InternalErrorException();
        }
        DB::commit();

        return response($definition, 201);
    }

    /**
     * いいね作成
     *
     * @param integer $id
     * @return void
     */
    public function like(int $id) {
        $definition = Definition::where('id', $id)->with('likes')->first();
        if(!$definition) return abort(404);

        $definition->likes()->detach(Auth::user()->id);
        $definition->likes()->attach(Auth::user()->id);

        return ['definition_id' => $id];
    }

    /**
     * いいね削除
     *
     * @param integer $id
     * @return void
     */
    public function deleteLike(int $id) {
        $definition = Definition::where('id', $id)->with('likes')->first();
        if(!$definition) abort(404);

        $definition->likes()->detach(Auth::user()->id);

        return ['definition_id' => $id];
    }

    /**
     * コメント投稿
     *
     * @param Definition $definition
     * @param StoreComment $request
     * @return void
     */
    public function comment(int $id, Definition $definition, StoreComment $request) {
        DB::beginTransaction();
        try {
            $comment = new Comment();
            $comment->content = $request->get('content');
            $comment->user_id = Auth::user()->id;
            $definition->comments()->save($comment);
        } catch(\Exception $e) {
            DB::rollback();
            throw new InternalErrorException();
        }
        DB::commit();

        $new_comment = Comment::where('id', $comment->id)->with('author')->first();

        return response($new_comment, 201);
    }
}
