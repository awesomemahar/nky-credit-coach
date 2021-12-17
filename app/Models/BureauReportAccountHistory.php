<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BureauReportAccountHistory extends Model
{
    use HasFactory;

    public function accountTitle(){
        return $this->belongsTo(BureauAccountTitle::class,'bureau_account_title_id');
    }
}
