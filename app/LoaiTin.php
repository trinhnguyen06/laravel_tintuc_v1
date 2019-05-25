<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoaiTin extends Model
{
    //
    use SoftDeletes;
    protected $table = "LoaiTin";

    public function theloai(){
        return $this->belongsTo('App\TheLoai', 'idTheLoai', 'id');
    }

    public function tinTuc(){
        return $this->hasMany('App\TinTuc', 'idLoaiTin', 'id');
    }
}
