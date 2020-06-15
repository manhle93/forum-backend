<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BinhLuanSanPham extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getCreatedAtAttribute()
    {
        Carbon::setLocale('vi');
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
}
