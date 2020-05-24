<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class BaiViet extends Model
{
    protected $fillable = ['tieu_de','noi_dung','loai','user_id','chu_de_id'];
    public function user(){
        return $this->belongsTo(User::class,);
    }
    public function getCreatedAtAttribute()
    {
        Carbon::setLocale('vi');
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
    public function binhLuans(){
        return $this->hasMany(BinhLuan::class);
    }
    public function chuDe(){
        return $this->belongsTo(ChuDe::class,);
    }
}
