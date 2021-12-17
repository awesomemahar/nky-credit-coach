<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'category',
        'status',
        'user_id',
        'letter',
        'letter_type',
        'by_admin',
        'bulk_letters',
        'letter_status'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
