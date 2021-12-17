<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function flow(){
        return $this->hasMany(LetterFlow::class,'reason_id');
    }

//    public function userflow($id){
//        return $this->hasOne(LetterFlow::class,'reason_id')->where('id',$id)->first();
//    }
//
//    public function adminflow(){
//        return $this->hasOne(LetterFlow::class,'reason_id');
//    }
}
