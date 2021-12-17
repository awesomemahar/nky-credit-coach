<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterFlow extends Model
{
    use HasFactory;

    public function reason(){
        return $this->belongsTo(Reason::class,'reason_id');
    }

    public function bureauLetter(){
        return $this->belongsTo(Letter::class,'bureau_letter_id');
    }

    public function furnisherLetter(){
        return $this->belongsTo(Letter::class,'furnisher_letter_id');
    }

    public function collectionAgencyLetter(){
        return $this->belongsTo(Letter::class,'collection_agency_letter_id');
    }
}
