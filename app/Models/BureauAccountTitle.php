<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BureauAccountTitle extends Model
{
    use HasFactory;

    public function accounts(){
        return $this->hasMany(BureauReportAccount::class);
    }

    public function accountHistories(){
        return $this->hasMany(BureauReportAccountHistory::class);
    }
}
