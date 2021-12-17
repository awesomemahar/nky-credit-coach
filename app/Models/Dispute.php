<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    use HasFactory;

    public function accountHistory(){
        return $this->belongsTo(BureauReportAccountHistory::class,'account_history_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'client_id');
    }

    public function disputeReason(){
        return $this->belongsTo(Reason::class,'reason_id');
    }

    public function creditorContact(){
        return $this->belongsTo(BureauCreditorContact::class,'bureau_creditor_contact_id');
    }

}
