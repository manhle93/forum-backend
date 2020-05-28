<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChuDe extends Model
{
    protected $guarded = [];
    // protected $appends = ['so_bai_viet'];

    // public function getSoBaiVietAttribute()
    // {
    //     return BaiViet::where('chu_de_id', $this->attributes['id'])->count();
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
