<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TinTuc extends Model
{
    //
    use SoftDeletes;
    protected $table = "TinTuc";

    public function loaiTin(){
        return $this->belongsTo('App\LoaiTin', 'idLoaiTin', 'id');
    }

    public function comment(){
        return $this->hasMany('App\Comment', 'idTinTuc', 'id');
    }
}
