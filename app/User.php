<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = [
        'definitions_count'
    ];

    // JSONに含める属性
    protected $visible = [
        'definitions_count', 'name', 'definitions'
    ];

    public function getDefinitionsCountAttribute() {
        return $this->definitions->count();
    }

    /**
     * リレーションシップ - definitionsテーブル
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function definitions() {
        return $this->hasMany('App\Definition')->with('word');
    }

    public function likes() {
        return $this->hasMany('App\Like');
    }
}