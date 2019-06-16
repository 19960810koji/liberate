<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Definition extends Model {

    protected $keyType = 'int';

    protected $perPage = 15;

    protected $visible = [
        'id', 'definition', 'contributor', 'word'
    ];

    public function contributor() {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }

    public function word() {
        return $this->belongsTo('App\Word', 'word_id', 'id', 'words');
    }
}
