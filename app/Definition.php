<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Definition extends Model {

    protected $keyType = 'int';

    protected $perPage = 15;

    protected $appends = [
        'likes_count', 'liked_by_user'
    ];

    protected $visible = [
        'id', 'definition', 'contributor', 'word', 'likes_count', 'liked_by_user', 'comments'
    ];

    public function getLikesCountAttribute() {
        return $this->likes->count();
    }

    public function getLikedByUserAttribute() {
        if (Auth::guest()) return false;

        return $this->likes->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }

    public function contributor() {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }

    public function word() {
        return $this->belongsTo('App\Word', 'word_id', 'id', 'words');
    }

    public function likes() {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    public function comments() {
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }
}
