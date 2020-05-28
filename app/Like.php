<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];
    public function binhLuan(){
        return $this->belongsTo(BinhLuan::class, 'reference_id');
    }
}
