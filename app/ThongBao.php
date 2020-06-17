<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    protected $guarded = [];
    public function userTuongTac()
    {
        return $this->belongsTo(User::class, 'user_id_tuong_tac');
    }
    
    public function getCreatedAtAttribute()
    {
        Carbon::setLocale('vi');
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
}
