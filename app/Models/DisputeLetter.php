<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisputeLetter extends Model
{
    use HasFactory;

    public function reason(){
        return $this->belongsTo(Letter::class,'reason_id');
    }

    public function records(){
        return $this->hasMany(DisputeLetterRecord::class);
    }

    public function dispute(){
        return $this->belongsTo(Dispute::class,'dispute_uid', 'uid');
    }
}
