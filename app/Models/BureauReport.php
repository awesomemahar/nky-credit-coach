<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BureauReport extends Model
{
    use HasFactory;

    public function reportSummary(){
        return $this->hasMany(BureauReportSummary::class);
    }

    public function reportInformation(){
        return $this->hasMany(ReportInformation::class);
    }

    public function bureauContacts(){
        return $this->hasMany(BureauCreditorContact::class);
    }

    public function bureauInquiries(){
        return $this->hasMany(BureauReportInquiry::class);
    }

    public function accountTitles(){
        return $this->hasMany(BureauAccountTitle::class);
    }

    public function bureauReportInformation($id){
        return $this->hasOne(ReportInformation::class)->where('bureau_id',$id)->first();
    }

    public function reportHistory(){
        return $this->hasMany(BureauReportAccountHistory::class);
    }

    public static function getDisputesInfo($report_id, $type)
    {
        return DB::table('disputes')
            ->join('bureau_report_account_histories', 'disputes.account_history_id', '=', 'bureau_report_account_histories.id')
            ->where('bureau_report_account_histories.bureau_report_id', $report_id)
            ->where($type, 1)
            ->count();
    }

    public static function getDisputesTypeInfo($report_id, $bureau, $type)
    {
        return DB::table('disputes')
            ->join('bureau_report_account_histories', 'disputes.account_history_id', '=', 'bureau_report_account_histories.id')
            ->where('bureau_report_account_histories.bureau_report_id', $report_id)
            ->where($bureau, 1)
            ->where('type',$type)
            ->count();
    }
}
