<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function binhLuans(){
        return $this->hasMany(BinhLuan::class);
    }
    public function chuDe(){
        return $this->belongsTo(ChuDe::class);
    }
}
