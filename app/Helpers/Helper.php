<?php
namespace App\Helpers;

use App\Models\BureauCreditorContact;
use App\Models\Dispute;

class Helper
{
    public static function bravo()
    {
        return '<strong>Bob?! Is that you?!</strong>';
    }

    public static function isDisputeValid($id, $type,$client_id)
    {
        $dispute = Dispute::where('account_history_id', $id)->where('client_id',$client_id)->where($type, 1)->first();
        if(!is_null($dispute)){
            return false;
        }else{
            return true;
        }
    }

//    public static function getCreditors($name, $report_id){
//        if (strpos($name, '/') !== false) {
//            $name = strtok($name, "/");
//        }elseif(strpos($name, ' ') !== false){
//            $name = strtok($name, " ");
//        }else{
//            $name = substr($name, 0, 5);;
//        }
//        $creditors = BureauCreditorContact::where('bureau_report_id', $report_id)->where('creditor_name', 'LIKE', '%'.$name.'%')->pluck('creditor_name', 'id');
//        return $creditors;
//    }
}