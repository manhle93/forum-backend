<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BinhLuan extends Model
{
    protected $guarded = [];
    public function baiViet()
    {
        return $this->belongsTo(BaiViet::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class, 'reference_id')->where('type', 'binh_luan');
    }
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
