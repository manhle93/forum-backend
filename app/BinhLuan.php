<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    public function baiViet(){
        return $this->belongsTo(BaiViet::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
