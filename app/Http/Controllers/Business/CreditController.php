<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\BureauReport;
use App\Models\BureauReportAccountHistory;
use App\Models\Letter;
use App\Models\Reason;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function index(Request $request,$id) {
        if(!$request->has('tab')){
            $tab = 'dashboard';
        }else{
            if(strtolower($request->query('tab') == 'dashboard')){
                $tab = strtolower($request->query('tab'));
            }elseif(strtolower($request->query('tab') == 'new_dispute')){
                $tab = strtolower($request->query('tab'));
            }elseif(strtolower($request->query('tab') == 'information')){
                $tab = strtolower($request->query('tab'));
            }elseif(strtolower($request->query('tab') == 'import')){
                $tab = strtolower($request->query('tab'));
            }elseif(strtolower($request->query('tab') == 'credit_report')){
                $tab = strtolower($request->query('tab'));
            }else{
                $tab = 'dashboard';
            }
        }

        $page = 'My Clients';
        $client = User::with('reminder','documents')->where('id', $id)->first();
        $report = BureauReport::where('client_id',$id)->orderBy('id')->first();
        return view('business.credit.show', compact('page', 'client','tab','report'));
    }
    public function module($id) {
        $client = User::find($id);
        $page = 'My Clients';
        return view('business.credit.module', compact('page', 'client'));
    }
    public function form($id) {
        $client = User::find($id);
        $page = 'My Clients';
        return view('business.credit.form', compact('page', 'client'));
    }
    public function stepB($id) {
        $client = User::find($id);
        $page = 'My Clients';
        return view('business.credit.step-b', compact('page', 'client'));
    }
    public function editor($id) {
        $client = User::find($id);
        $page = 'My Clients';
        return view('business.credit.editor', compact('page', 'client'));
    }

    public function creditDisputeType($client, $type){
        $client = User::findorfail($client);
        $ids = array();
        array_push($ids,1);
        array_push($ids, auth()->user()->id);

        $reasons= Reason::whereHas('flow')->whereIn('user_id',$ids)->where('status',1)->pluck('title', 'id');
        if(count($reasons) < 1){
            return redirect()->route('business.disputes')->with('error', 'Need to have at least one active reason to create dispute.');
        }
        if(isset($client->latestReport)){
            $creditors = $client->latestReport->bureauContacts;
            if($type == 'collections' ){
                $reports = BureauReportAccountHistory::where('bureau_report_id',$client->latestReport->id)->where('transunion','CO')->orWhere('experian','CO')->orWhere('equifax','CO')->get();
            }elseif($type == 'late_payments'){
                $reports = BureauReportAccountHistory::where('bureau_report_id',$client->latestReport->id)->where('transunion','LP')->orWhere('experian','LP')->orWhere('equifax','LP')->get();
            }
            $page = 'My Clients';
            return view('business.credit.dispute.type', compact('page','client','type','reports','reasons','creditors'));
        }else{
            return redirect()->route('business.credit.get.profile',['id'=>$client->id,'tab'=>'new_dispute'])->with('error', 'No report available!, please import credit report first and then look for the disputes.');
        }
    }

}
