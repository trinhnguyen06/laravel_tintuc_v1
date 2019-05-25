<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
    use SoftDeletes;
    protected $table = "Comment";

    public function tinTuc(){
        return $this->belongsTo('App\TinTuc', 'idTinTuc', 'id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'idUser', 'id');
    }
}
