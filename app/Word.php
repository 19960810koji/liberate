<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model {
    protected $visible = [
        'word',
    ];

    public function definitions() {
        return $this->hasMany('App\Definition');
    }
}
