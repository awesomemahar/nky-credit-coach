<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;


class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable, SubscriptionsSync;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'email',
        'no_email_check',
        'social_security_number',
        'dob',
        'phone',
        'phone_work',
        'ext',
        'phone_m',
        'fax',
        'mailing_address',
        'city',
        'state',
        'zip_code',
        'country',
        'company_name',
        'picture',
        'type',
        'subscription_package_id',
        'subscription_status',
        'password',
        'business_id',
        'iq_username',
        'iq_password',
        'last_four_ssn'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reminder()
    {
        return $this->hasMany(Reminder::class,'owner_id');
    }

    public function disputeLetters()
    {
        return $this->hasMany(DisputeLetter::class,'owner_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class,'owner_id');
    }

    public function documents()
    {
        return $this->hasMany(ClientDocument::class, 'client_id', 'id');
    }

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    public function reports()
    {
        return $this->hasMany(BureauReport::class, 'client_id');
    }

    public function latestReport()
    {
        return $this->hasOne(BureauReport::class, 'client_id')->orderBy('id','desc');
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class,'owner_id');
    }

    public function currentPlan()
    {
        return $this->belongsTo(SubscriptionPackage::class,'subscription_package_id');
    }

    public function clients()
    {
        return $this->hasMany(User::class,'business_id')->where('type',3);
    }
}
