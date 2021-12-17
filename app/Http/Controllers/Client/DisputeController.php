<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ApiLog;
use App\Models\Bureau;
use App\Models\BureauAccountTitle;
use App\Models\BureauCreditorContact;
use App\Models\BureauReport;
use App\Models\BureauReportAccount;
use App\Models\BureauReportAccountHistory;
use App\Models\BureauReportInquiry;
use App\Models\BureauReportSummary;
use App\Models\Dispute;
use App\Models\DisputeLetter;
use App\Models\Letter;
use App\Models\Reason;
use App\Models\ReportInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DisputeController extends Controller
{
    public function creditDisputeType($type){
        $client = auth()->user();
        $ids = array();
        array_push($ids,1);
        array_push($ids, auth()->user()->id);

        $reasons= Reason::whereHas('flow')->whereIn('user_id',$ids)->where('status',1)->pluck('title', 'id');
        if(count($reasons) < 1){
            return redirect()->route('client.disputes')->with('error', 'Need to have at least one active reason to create dispute.');
        }
        if(isset($client->latestReport)){
            $creditors = $client->latestReport->bureauContacts;
            if($type == 'collections' ){
                $reports = BureauReportAccountHistory::where('bureau_report_id',$client->latestReport->id)->where('transunion','CO')->orWhere('experian','CO')->orWhere('equifax','CO')->get();
            }elseif($type == 'late_payments'){
                $reports = BureauReportAccountHistory::where('bureau_report_id',$client->latestReport->id)->where('transunion','LP')->orWhere('experian','LP')->orWhere('equifax','LP')->get();
            }
            $page = 'My Clients';
            return view('client.credit.dispute.type', compact('page','client','type','reports','reasons','creditors'));
        }else{
            return redirect()->route('client.credit.profile',['tab'=>'new_dispute'])->with('error', 'No report available!, please import credit report first and then look for the disputes.');
        }
    }

    public function getDisputes(){
        $page = 'Disputes';
        $letters = DisputeLetter::where(function ($query) {
            $query->where('owner_id', auth()->user()->id)
                ->orWhere('client_id', auth()->user()->id);
        })->orderBy('id','desc')->get();
//        dd($letters);
//        $collection = new \Illuminate\Support\Collection();
//        $letters = $collection->merge($letters)->merge($creditor_letters)->sortByDesc('created_at');
        return view('client.disputes.letters', compact('page','letters'));

    }

    public function getDisputeLetter($id){
        $letter = null;
        $letter = DisputeLetter::where('id', $id)
            ->where(function ($query) {
                $query->where('owner_id', auth()->user()->id)
                    ->orWhere('client_id', auth()->user()->id);
            })
            ->first();
        if(!is_null($letter)){
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($letter->letter);
            return $pdf->stream();
        }else{
            return redirect()->route('client.disputes')->with('error', 'No letter found.');
        }
    }

    public function editDisputeLetter($id){
        $page = 'Disputes';
        $letter = DisputeLetter::where('id', $id)
            ->where(function ($query) {
                $query->where('owner_id', auth()->user()->id)
                    ->orWhere('client_id', auth()->user()->id);
            })
            ->first();
        if(!is_null($letter)){
            return view('client.disputes.editor', compact('page','letter'));
        }else{
            return redirect()->route('client.disputes')->with('error', 'No letter found.');
        }
    }

    public function editDisputeLetterPost(Request  $request, $id){
        $page = 'Disputes';
        $letter = DisputeLetter::where('id', $id)
            ->where(function ($query) {
                $query->where('owner_id', auth()->user()->id)
                    ->orWhere('client_id', auth()->user()->id);
            })
            ->first();
        if(!is_null($letter)){

            if(strtolower($request->submitButton) == 'pdf'){
                $validator = Validator::make($request->all(), [
                    'letter' => 'required|min:10'
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->all());
                }

                $pdf = App::make('dompdf.wrapper');
                $pdf->loadHTML($request->letter);
                return $pdf->download();
            }elseif(strtolower($request->submitButton) == 'update'){
                $validator = Validator::make($request->all(), [
                    'letter' => 'required|min:10'
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->all());
                }
                $letter->letter = $request->letter;
                $letter->save();

                return redirect()->back()->with('success', 'Dispute letter updated successfully.');
            }else{
                return redirect()->route('client.disputes')->with('error', 'Something went wrong, please try later.');
            }

            return view('client.disputes.editor', compact('page','letter'));
        }else{
            return redirect()->route('client.disputes')->with('error', 'No letter found.');
        }
    }

    public function faxDisputeLetter(Request  $request,$id){
        $page = 'Disputes';
        $letter = DisputeLetter::where('id', $id)->where(function ($query) {
            $query->where('owner_id', auth()->user()->id)
                ->orWhere('client_id', auth()->user()->id);
        })->where('fax_sent',0)->first();
        if(!is_null($letter)){
            $letter->fax_sent = 1;
            $letter->save();
            return redirect()->back()->with('success', 'Fax sent successfully to the bureau.');
        }else{
            return redirect()->route('client.disputes')->with('error', 'No letter found.');
        }
    }

    public function createDispute (Request $request, $type){
        $client = auth()->user();
        $validator = Validator::make($request->all(), [
            'bureau' => 'required|array',
            'creditor.*' => 'required_with:bureau.*',
        ],
            ['bureau.required' => 'Please select at least one bureau.',
                'creditor.*.required_with'=>'Please select creditor contact along with bureau.'
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        if(count($request->get('bureau')) > 0){
            $tracking_id = uniqid();
            try {
                DB::beginTransaction();
                foreach ($request->get('bureau') as $id => $value){
                    $bureaus = $request->get('bureau');
                    $dispute = new Dispute();
                    $dispute->uid = $tracking_id;
                    $dispute->bureau_creditor_contact_id = $request->creditor[$id];
                    $dispute->owner_id = auth()->user()->id;
                    $dispute->client_id = $client->id;
                    $dispute->account_history_id = $id;
                    $dispute->reason_id = $request->reason[$id];
                    $dispute->type = $type;
                    if(in_array('tu',$bureaus[$id],true )){
                        $dispute->is_tu = 1;
                        $dispute->tu_status = 'Pending';
                    }
                    if(in_array('exp',$bureaus[$id],true )){
                        $dispute->is_exp = 1;
                        $dispute->exp_status = 'Pending';
                    }
                    if(in_array('eqfx',$bureaus[$id],true )){
                        $dispute->is_eqfx = 1;
                        $dispute->eqfx_status = 'Pending';
                    }
                    $dispute->account_status = 'Pending';
                    $dispute->save();

                }

                $tu_diputes = Dispute::where('uid',$tracking_id)->where('is_tu',1)->orderBy('id','asc')->get();
                $tu_reasons = [];
                foreach ($tu_diputes as $dispute){
                    if(array_key_exists($dispute->reason_id,$tu_reasons)){
                        $tu_reasons[$dispute->reason_id] [] = $dispute->id;
                    }else{
                        $tu_reasons[$dispute->reason_id] = array();
                        $tu_reasons[$dispute->reason_id] [] = $dispute->id;
                    }
                }

                $exp_diputes = Dispute::where('uid',$tracking_id)->where('is_exp',1)->orderBy('id','asc')->get();
                $exp_reasons = [];
                foreach ($exp_diputes as $dispute){
                    if(array_key_exists($dispute->reason_id,$exp_reasons)){
                        $exp_reasons[$dispute->reason_id] [] = $dispute->id;
                    }else{
                        $exp_reasons[$dispute->reason_id] = array();
                        $exp_reasons[$dispute->reason_id] [] = $dispute->id;
                    }
                }

                $eqfx_diputes = Dispute::where('uid',$tracking_id)->where('is_eqfx',1)->orderBy('id','asc')->get();
                $eqfx_reasons = [];
                foreach ($eqfx_diputes as $dispute){
                    if(array_key_exists($dispute->reason_id,$eqfx_reasons)){
                        $eqfx_reasons[$dispute->reason_id] [] = $dispute->id;
                    }else{
                        $eqfx_reasons[$dispute->reason_id] = array();
                        $eqfx_reasons[$dispute->reason_id] [] = $dispute->id;
                    }
                }

                $creditor_diputes = Dispute::where('uid',$tracking_id)->orderBy('id','asc')->get();
                $credtior_contacts = [];
                foreach ($creditor_diputes as $dispute){
                    if(array_key_exists($dispute->bureau_creditor_contact_id,$credtior_contacts)){
                        $credtior_contacts[$dispute->bureau_creditor_contact_id] [] = $dispute->id;
                    }else{
                        $credtior_contacts[$dispute->bureau_creditor_contact_id] = array();
                        $credtior_contacts[$dispute->bureau_creditor_contact_id] [] = $dispute->id;
                    }
                }



                $client_info = ucwords($client->first_name).' '.$client->last_name .' <br> ' .$client->mailing_address;
                $company_letter  = Letter::where('title','dispute letter')->first();
                if(is_null($company_letter)){
                    $company_letter = "<p>[DATE]</p><p>[CLIENT]</p><p>[COMPANY]:</p><p>[REASONS]<br /><br />Kind Regards,<br />[CLIENT]</p>";
                }else{
                    $company_letter = $company_letter->letter;
                }

                $tu_accounts = '';
                foreach ($tu_reasons as $reason =>$values ){
                    $reason = Reason::find($reason);
                    $tu_accounts .=$reason->content .' <br>';
                    foreach ($values as $value){

                        $get_dispute = Dispute::find($value);
                        $get_dispute_history = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',1)->first();
                        $account_detail = 'Account No: '.$get_dispute_history->account. ' <br>';
                        $tu_accounts  .= $account_detail;

                    }
                    $tu_accounts .= " <br>";
                }
                if(count($tu_reasons) > 0){
                    $dispute_letter  = DisputeLetter::where('dispute_uid',$tracking_id)->where('company','TransUnion')->first();
                    if(is_null($dispute_letter)){
                        $dispute_letter = new DisputeLetter();
                        $dispute_letter->dispute_uid = $tracking_id;
                        $dispute_letter->owner_id = auth()->user()->id;
                        $dispute_letter->company = 'TransUnion';
                        $dispute_letter->save();

                    }

                    $letter = $company_letter;
                    $dt = Carbon::now();
                    $dt->toDayDateTimeString();

                    $letter = str_replace('[DATE]',$dt, $letter);
                    $letter = str_replace('[CLIENT]',$client_info, $letter);
                    $letter = str_replace('[COMPANY]','TransUnion Information Services LLC', $letter);
                    $letter = str_replace('[REASONS]',$tu_accounts, $letter);
                    $dispute_letter->letter = $letter;
                    $dispute_letter->save();
                }

                $exp_accounts = '';
                foreach ($exp_reasons as $reason =>$values ){
                    $reason = Reason::find($reason);
                    $exp_accounts .=$reason->content .' <br> ';
                    foreach ($values as $value){

                        $get_dispute = Dispute::find($value);
                        $get_dispute_history = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',2)->first();
                        $account_detail = 'Account No: '.$get_dispute_history->account. ' <br>';
                        $exp_accounts  .= $account_detail;

                    }

                    $exp_accounts .= " <br>";

                }
                if(count($exp_reasons) > 0){
                    $dispute_letter  = DisputeLetter::where('dispute_uid',$tracking_id)->where('company','Experian')->first();
                    if(is_null($dispute_letter)){
                        $dispute_letter = new DisputeLetter();
                        $dispute_letter->dispute_uid = $tracking_id;
                        $dispute_letter->owner_id = auth()->user()->id;
                        $dispute_letter->company = 'Experian';
                        $dispute_letter->save();

                    }

                    $letter = $company_letter;
                    $dt = Carbon::now();
                    $dt->toDayDateTimeString();

                    $letter = str_replace('[DATE]',$dt, $letter);
                    $letter = str_replace('[CLIENT]',$client_info, $letter);
                    $letter = str_replace('[COMPANY]','Experian Information Services LLC', $letter);
                    $letter = str_replace('[REASONS]',$exp_accounts, $letter);
                    $dispute_letter->letter = $letter;
                    $dispute_letter->save();
                }

                $eqfx_accounts = '';
                foreach ($eqfx_reasons as $reason =>$values ){
                    $reason = Reason::find($reason);
                    $eqfx_accounts .=$reason->content .' <br> ';
                    foreach ($values as $value){

                        $get_dispute = Dispute::find($value);
                        $get_dispute_history = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',3)->first();
                        $account_detail = 'Account No: '.$get_dispute_history->account. ' <br>';
                        $eqfx_accounts  .= $account_detail;

                    }

                    $eqfx_accounts .= " <br>";

                }
                if(count($eqfx_reasons) > 0){
                    $dispute_letter  = DisputeLetter::where('dispute_uid',$tracking_id)->where('company','Equifax')->first();
                    if(is_null($dispute_letter)){
                        $dispute_letter = new DisputeLetter();
                        $dispute_letter->dispute_uid = $tracking_id;
                        $dispute_letter->owner_id = auth()->user()->id;
                        $dispute_letter->company = 'Equifax';
                        $dispute_letter->save();

                    }

                    $letter = $company_letter;
                    $dt = Carbon::now();
                    $dt->toDayDateTimeString();

                    $letter = str_replace('[DATE]',$dt, $letter);
                    $letter = str_replace('[CLIENT]',$client_info, $letter);
                    $letter = str_replace('[COMPANY]','Equifax Information Services LLC', $letter);
                    $letter = str_replace('[REASONS]',$eqfx_accounts, $letter);
                    $dispute_letter->letter = $letter;
                    $dispute_letter->save();
                }

                $creditor_accounts = 'This letter is to certify that i am having issues with the following accounts mentioned below. <br> <br> ';
                foreach ($credtior_contacts as $credtior_contact =>$values ){

                    $contact = BureauCreditorContact::find($credtior_contact);
                    $dispute_letter = new DisputeLetter();
                    $dispute_letter->dispute_uid = $tracking_id;
                    $dispute_letter->owner_id = auth()->user()->id;
                    $dispute_letter->company = $contact->creditor_name;
                    $dispute_letter->save();

                    $letter = $company_letter;
                    $dt = Carbon::now();
                    $dt->toDayDateTimeString();

                    $letter = str_replace('[DATE]',$dt, $letter);
                    $letter = str_replace('[CLIENT]',$client_info, $letter);
                    $letter = str_replace('[COMPANY]',$contact->creditor_name .' <br> '. $contact->address, $letter);


                    foreach ($values as $value){

                        $get_dispute = Dispute::find($value);
                        $get_dispute_history = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',3)->first();
                        $account_detail = 'Account No: '.$get_dispute_history->account. ' <br> '.' Reason: '. ucwords($get_dispute->disputeReason->title) .' <br> ';
                        $creditor_accounts  .= $account_detail;

                    }

                    $letter = str_replace('[REASONS]',$creditor_accounts, $letter);
                    $dispute_letter->letter = $letter;
                    $dispute_letter->save();


                }

//
//                }
//
//                foreach ($exp_reasons as $reason=>$values){
//
//                    $reason_letter  = DisputeLetter::where('dispute_uid',$tracking_id)->where('reason_id', $reason)->where('bureau_id',2)->first();
//                    if(is_null($reason_letter)){
//                        $reason_letter = new DisputeLetter();
//                        $reason_letter->dispute_uid = $tracking_id;
//                        $reason_letter->owner_id = auth()->user()->id;
//                        $reason_letter->reason_id = $reason;
//                        $reason_letter->bureau_id = 2;
//                        $reason_letter->bureau = 'Experian';
//                        $reason_letter->save();
//
//                    }
//
//                    $bureau_info = 'Experian Information Services LLC';
//                    $letter_og = Letter::find($reason);
//                    $letter = $letter_og->letter;
//                    $dt = Carbon::now();
//                    $dt->toDayDateTimeString();
//
//                    $letter = str_replace('[DATE]',$dt, $letter);
//                    $letter = str_replace('[CLIENT]',$client_info, $letter);
//                    $letter = str_replace('[BUREAU]',$bureau_info, $letter);
//                    $accounts = '';
//                    foreach ($values as $value){
//
//                        $letter_record = new DisputeLetterRecord();
//                        $letter_record->dispute_letter_id = $reason_letter->id;
//                        $letter_record->dispute_id = $value;
//                        $letter_record->save();
//
//                        $get_dispute = Dispute::find($value);
//                        $get_dispute = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',2)->first();
//                        $account_detail = 'Account No: '.$get_dispute->account. ' <br> '.' Reason: '. ucwords($letter_og->title) .' <br> ';
//                        $accounts  .= $account_detail;
//
//                    }
//                    $letter = str_replace('[ACCOUNTS]',$accounts, $letter);
//                    $reason_letter->letter = $letter;
//                    $reason_letter->save();
//
//                }
//
//                foreach ($eqfx_reasons as $reason=>$values){
//
//                    $reason_letter  = DisputeLetter::where('dispute_uid',$tracking_id)->where('reason_id', $reason)->where('bureau_id',3)->first();
//                    if(is_null($reason_letter)){
//                        $reason_letter = new DisputeLetter();
//                        $reason_letter->dispute_uid = $tracking_id;
//                        $reason_letter->owner_id = auth()->user()->id;
//                        $reason_letter->reason_id = $reason;
//                        $reason_letter->bureau_id = 3;
//                        $reason_letter->bureau = 'Equifax';
//                        $reason_letter->save();
//
//                    }
//
//                    $bureau_info = 'Equifax Information Services LLC';
//                    $letter_og = Letter::find($reason);
//                    $letter = $letter_og->letter;
//                    $dt = Carbon::now();
//                    $dt->toDayDateTimeString();
//
//                    $letter = str_replace('[DATE]',$dt, $letter);
//                    $letter = str_replace('[CLIENT]',$client_info, $letter);
//                    $letter = str_replace('[BUREAU]',$bureau_info, $letter);
//                    $accounts = '';
//                    foreach ($values as $value){
//
//                        $letter_record = new DisputeLetterRecord();
//                        $letter_record->dispute_letter_id = $reason_letter->id;
//                        $letter_record->dispute_id = $value;
//                        $letter_record->save();
//
//                        $get_dispute = Dispute::find($value);
//                        $get_dispute = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',3)->first();
//                        $account_detail = 'Account No: '.$get_dispute->account. ' <br> '.' Reason: '. ucwords($letter_og->title) .' <br> ';
//                        $accounts  .= $account_detail;
//
//                    }
//                    $letter = str_replace('[ACCOUNTS]',$accounts, $letter);
//                    $reason_letter->letter = $letter;
//                    $reason_letter->save();
//
//                }
//
//                foreach ($creditors as $creditor=>$values){
//                    $creditor_letter  = CreditorLetter::where('dispute_uid',$tracking_id)->where('creditor_id', $creditor)->first();
//                    if(is_null($creditor_letter)){
//                        $creditor_letter = new CreditorLetter();
//                        $creditor_letter->dispute_uid = $tracking_id;
//                        $creditor_letter->owner_id = auth()->user()->id;
//                        $creditor_letter->creditor_id = $creditor;
//                        $creditor_letter->save();
//
//                    }
//
//                    $creditor_info = $creditor_letter->creditor->creditor_name.'<br>'.$creditor_letter->creditor->address;
//                    $letter_og = Letter::where('title','Creditor Letter')->first();
//                    if(!is_null($letter_og)){
//                        $letter = $letter_og->letter;
//                    }else{
//                        $letter = "<p>[DATE]</p><p>[CLIENT]</p><p>[CREDITOR]:&nbsp;</p><p>This letter is to certify that the mentioned reasons on my accounts mentioned below are wrong. Please look into the accounts and review the credit history of the following accounts.<br /><br />[ACCOUNTS]<br /><br />Kind Regards,<br />[CLIENT]</p>";
//                    }
//
//                    $dt = Carbon::now();
//                    $dt->toDayDateTimeString();
//
//                    $letter = str_replace('[DATE]',$dt, $letter);
//                    $letter = str_replace('[CLIENT]',$client_info, $letter);
//                    $letter = str_replace('[CREDITOR]',$creditor_info, $letter);
//                    $accounts = '';
//                    foreach ($values as $value){
//
//                        $letter_record = new CreditorLetterRecord();
//                        $letter_record->creditor_letter_id = $creditor_letter->id;
//                        $letter_record->dispute_id = $value;
//                        $letter_record->save();
//
//                        $get_dispute = Dispute::find($value);
//                        $get_dispute = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',3)->first();
//                        $account_detail = 'Account No: '.$get_dispute->account. ' <br> '.' Reason: '. ucwords($letter_og->title) .' <br> ';
//                        $accounts  .= $account_detail;
//
//                    }
//                    $letter = str_replace('[ACCOUNTS]',$accounts, $letter);
//                    $creditor_letter->letter = $letter;
//                    $creditor_letter->save();
//
//                }
                DB::commit();
                return redirect()->route('client.disputes')->with('success', 'Dispute created successfully.');
            }catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()->with('error', 'Something went wrong, Please try later.');
            }
        }else{
            return redirect()->back()->with('error', 'Please provide IdentityIQ the credentials of client along with last 4 digit of ssn in order to import the credit report.');
        }
        return redirect()->route('client.index')->with('success', "Dispute created successfully.");
    }

    public function createDisputeUpdate (Request $request, $type){
        $client = auth()->user();
        $validator = Validator::make($request->all(), [
            'bureau' => 'required|array',
            'creditor.*' => 'required_with:bureau.*',
        ],
            ['bureau.required' => 'Please select at least one bureau.',
                'creditor.*.required_with'=>'Please select creditor contact along with bureau.'
            ]
        );


        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        if(count($request->get('bureau')) > 0){
            $tracking_id = uniqid();
            try {
                DB::beginTransaction();
                foreach ($request->get('bureau') as $id => $value){
                    $bureaus = $request->get('bureau');
                    $dispute = new Dispute();
                    $dispute->uid = $tracking_id;
                    $dispute->bureau_creditor_contact_id = $request->creditor[$id];
                    $dispute->owner_id = $client->id;
                    $dispute->client_id = $client->id;
                    $dispute->account_history_id = $id;
                    $dispute->reason_id = $request->reason[$id];
                    $dispute->type = $type;
                    if(in_array('tu',$bureaus[$id],true )){
                        $dispute->is_tu = 1;
                        $dispute->tu_status = 'Pending';
                    }
                    if(in_array('exp',$bureaus[$id],true )){
                        $dispute->is_exp = 1;
                        $dispute->exp_status = 'Pending';
                    }
                    if(in_array('eqfx',$bureaus[$id],true )){
                        $dispute->is_eqfx = 1;
                        $dispute->eqfx_status = 'Pending';
                    }
                    $dispute->account_status = 'Pending';
                    $dispute->save();

                }

                $tu_diputes = Dispute::where('uid',$tracking_id)->where('is_tu',1)->orderBy('id','asc')->get();
                $tu_reasons = [];
                foreach ($tu_diputes as $dispute){
                    if(array_key_exists($dispute->reason_id,$tu_reasons)){
                        $tu_reasons[$dispute->reason_id] [] = $dispute->id;
                    }else{
                        $tu_reasons[$dispute->reason_id] = array();
                        $tu_reasons[$dispute->reason_id] [] = $dispute->id;
                    }
                }

                $exp_diputes = Dispute::where('uid',$tracking_id)->where('is_exp',1)->orderBy('id','asc')->get();
                $exp_reasons = [];
                foreach ($exp_diputes as $dispute){
                    if(array_key_exists($dispute->reason_id,$exp_reasons)){
                        $exp_reasons[$dispute->reason_id] [] = $dispute->id;
                    }else{
                        $exp_reasons[$dispute->reason_id] = array();
                        $exp_reasons[$dispute->reason_id] [] = $dispute->id;
                    }
                }

                $eqfx_diputes = Dispute::where('uid',$tracking_id)->where('is_eqfx',1)->orderBy('id','asc')->get();
                $eqfx_reasons = [];
                foreach ($eqfx_diputes as $dispute){
                    if(array_key_exists($dispute->reason_id,$eqfx_reasons)){
                        $eqfx_reasons[$dispute->reason_id] [] = $dispute->id;
                    }else{
                        $eqfx_reasons[$dispute->reason_id] = array();
                        $eqfx_reasons[$dispute->reason_id] [] = $dispute->id;
                    }
                }

                $creditor_diputes = Dispute::where('uid',$tracking_id)->orderBy('id','asc')->get();
                $credtior_contacts = [];
                foreach ($creditor_diputes as $dispute){
                    if(array_key_exists($dispute->reason_id,$credtior_contacts)){
                        $credtior_contacts[$dispute->reason_id] [] = $dispute->id;
                    }else{
                        $credtior_contacts[$dispute->reason_id] = array();
                        $credtior_contacts[$dispute->reason_id] [] = $dispute->id;
                    }
                }

                if(count($tu_reasons) > 0){
                    $this->generateBureauDisputeLetters($tu_reasons, $client,'TU',$tracking_id);
                }

                if(count($exp_reasons) > 0){
                    $this->generateBureauDisputeLetters($exp_reasons, $client,'EXP',$tracking_id);
                }

                if(count($eqfx_reasons) > 0){
                    $this->generateBureauDisputeLetters($eqfx_reasons, $client,'EQFX',$tracking_id);
                }

                if(count($credtior_contacts) > 0){
                    $this->generateCreditorDisputeLetters($credtior_contacts, $client,'CC',$tracking_id);
                }

                // creditor contacts containers all disputes on the basis of reasons
                if(count($credtior_contacts) > 0){
                    $this->generateAgencyDisputeLetters($credtior_contacts, $client,'AG',$tracking_id);
                }
                DB::commit();

                return redirect()->route('client.get.disputes.editor', $tracking_id)->with('message', 'Dispute created successfully.');

            }catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Opps! something went wrong, please try later.');
            }
        }else{
            return redirect()->back()->with('error', 'Please provide IdentityIQ the credentials of client along with last 4 digit of ssn in order to import the credit report.');
        }
    }

    public function importReport(){
        $user = auth()->user();

        if(!is_null($user->iq_username) && !is_null($user->iq_password) && !is_null($user->last_four_ssn) && !empty($user->iq_username) && !empty($user->iq_password) && !empty($user->last_four_ssn)){
            try {

                $client = new \GuzzleHttp\Client();

                $response = $client->post(
                    'http://18.222.162.33/getData/',
                    array(
                        'form_params' => array(
                            'email' => $user->iq_username,
                            'password' => $user->iq_password,
                            'ssn' => $user->last_four_ssn,
                        )
                    )
                );
                if($response->getStatusCode() == 200) {
                    $data = json_decode($response->getBody()->getContents(),true);
                    if(isset($data['Code']) && $data['Code'] == 400){
                        return redirect()->route('client.credit.get.profile',['id'=>$user->id,'tab'=>'import'])->with('error', 'Something went wrong, Please try later or import report again with the valid identity iq credentials.');
                    }
                    $personal_information = $data['Personal Information'];
                    $credit_score = $data['Credit Score'];
                    $summaries = $data['Summary'];
                    $inquiries = $data['Inquiries'];
                    $contacts = $data['Creditor Contacts'];
                    $accounts = $data['Account History'];


                    $report = BureauReport::where('iq_ref',$data['Report'][0]['Reference #'])->where('client_id',$user->id)->first();
                    if(is_null($report)){
                        DB::beginTransaction();
                        $report = new BureauReport();
                        $report->uid =uniqid();
                        $report->client_id = $user->id;
                        $report->iq_ref = $data['Report'][0]['Reference #'];
                        $report->iq_date = $data['Report'][0]['Report Date:'];
                        $report->save();

                        foreach ($personal_information as $information){
                            $bureau = Bureau::where('title', $information['key'])->orWhere('slug',$information['key'])->first();

                            $report_information = new ReportInformation();
                            $report_information->bureau_report_id = $report->id;
                            $report_information->bureau_id = $bureau->id;
                            $report_information->report_date = $information['values']['Credit Report Date'];
                            $report_information->name = $information['values']['Name'];
                            $report_information->also_known_as = $information['values']['Also Knows As'];
                            $report_information->former = $information['values']['Former'];
                            $report_information->date_of_birth = $information['values']['Date of Birth'];
                            $report_information->current_address = $information['values']['Current Address(es)'];
                            $report_information->previous_address = $information['values']['Previous Address(es)'];
                            $report_information->employers = $information['values']['Employers'];
                            $report_information->save();
                        }

                        foreach ($credit_score as $score) {
                            $bureau = Bureau::where('title', $score['key'])->orWhere('slug', $score['key'])->first();
                            $report_information = ReportInformation::where('bureau_report_id', $report->id)->where('bureau_id', $bureau->id)->first();
                            $report_information->credit_score = $score['values']['Credit Score'];
                            $report_information->lender_rank = $score['values']['Lender Rank'];
                            $report_information->score_scale = $score['values']['score Scale'];
                            $report_information->save();

                        }
                        foreach ($summaries as $summary) {
                            $bureau = Bureau::where('title', $summary['key'])->orWhere('slug', $summary['key'])->first();
                            $report_summary = new BureauReportSummary();
                            $report_summary->bureau_report_id = $report->id;
                            $report_summary->bureau_id = $bureau->id;
                            $report_summary->total_accounts = $summary['values']['Total Accounts'];
                            $report_summary->open_accounts = $summary['values']['Open Accounts'];
                            $report_summary->closed_accounts = $summary['values']['Closed Accounts'];
                            $report_summary->delinquent = $summary['values']['Delinquent'];
                            $report_summary->derogatory = $summary['values']['Derogatory'];
                            $report_summary->collection = $summary['values']['Collection'];
                            $report_summary->balances = $summary['values']['Balances'];
                            $report_summary->payments = $summary['values']['Payments'];
                            $report_summary->public_records = $summary['values']['Public Records'];
                            $report_summary->inquiries = $summary['values']['Inquiries(2 years)'];
                            $report_summary->save();
                        }

                        foreach ($inquiries as $inquiry){
                            $report_inquiry = new BureauReportInquiry();
                            $report_inquiry->bureau_report_id = $report->id;
                            $report_inquiry->creditor_name = $inquiry['Creditor Name'];
                            $report_inquiry->type_of_business = $inquiry['Type of Business'];
                            $report_inquiry->date_of_inquiry = $inquiry['Date of Inquiry'];
                            $report_inquiry->credit_bureau = $inquiry['Credit Bureau'];
                            $report_inquiry->save();
                        }
                        foreach ($contacts as $contact){
                            $report_contact = new BureauCreditorContact();
                            $report_contact->bureau_report_id = $report->id;
                            $report_contact->creditor_name = $contact['Creditor Name'];
                            $report_contact->address = $contact['Address'];
                            $report_contact->phone_number = $contact['Phone Number'];
                            $report_contact->save();
                        }

                        foreach ($accounts as $account){
                            $account_title = new BureauAccountTitle();
                            $account_title->title = $account['bank'];
                            $account_title->bureau_report_id = $report->id;
                            $account_title->save();

                            if(isset($account['TransUnion'])){
                                $bureau = Bureau::where('title', 'TransUnion')->orWhere('slug','transunion')->first();

                                $bu_account_details = $account['TransUnion'];
                                $bureau_account = new BureauReportAccount();
                                $bureau_account->bureau_report_id = $report->id;
                                $bureau_account->bureau_id = $bureau->id;
                                $bureau_account->client_id = 3;
                                $bureau_account->bureau_account_title_id = $account_title->id;
                                $bureau_account->account = $bu_account_details['Account #'];
                                $bureau_account->account_type = $bu_account_details['Account Type'];
                                $bureau_account->account_type_detail = $bu_account_details['Account Type - Detail'];
                                $bureau_account->bureau_code = $bu_account_details['Bureau Code'];
                                $bureau_account->account_status = $bu_account_details['Account Status'];
                                $bureau_account->monthly_payment = $bu_account_details['Monthly Payment'];
                                $bureau_account->date_opened = $bu_account_details['Date Opened'];
                                $bureau_account->balance = $bu_account_details['Balance'];
                                $bureau_account->no_of_months = $bu_account_details['No. of Months (terms)'];
                                $bureau_account->high_credit = $bu_account_details['High Credit'];
                                $bureau_account->credit_limit = $bu_account_details['Credit Limit'];
                                $bureau_account->past_due = $bu_account_details['Past Due'];
                                $bureau_account->payment_status = $bu_account_details['Payment Status'];
                                $bureau_account->last_reported = $bu_account_details['Last Reported'];
                                $bureau_account->comments = $bu_account_details['Comments'];
                                $bureau_account->date_last_active = $bu_account_details['Date Last Active'];
                                $bureau_account->date_of_last_payment = $bu_account_details['Date of Last Payment'];
                                $bureau_account->Save();
                            }

                            if(isset($account['Experian'])){
                                $bureau = Bureau::where('title', 'Experian')->orWhere('slug','experian')->first();

                                $bu_account_details = $account['Experian'];
                                $bureau_account = new BureauReportAccount();
                                $bureau_account->bureau_report_id = $report->id;
                                $bureau_account->bureau_id = $bureau->id;
                                $bureau_account->client_id = 3;
                                $bureau_account->bureau_account_title_id = $account_title->id;
                                $bureau_account->account = $bu_account_details['Account #'];
                                $bureau_account->account_type = $bu_account_details['Account Type'];
                                $bureau_account->account_type_detail = $bu_account_details['Account Type - Detail'];
                                $bureau_account->bureau_code = $bu_account_details['Bureau Code'];
                                $bureau_account->account_status = $bu_account_details['Account Status'];
                                $bureau_account->monthly_payment = $bu_account_details['Monthly Payment'];
                                $bureau_account->date_opened = $bu_account_details['Date Opened'];
                                $bureau_account->balance = $bu_account_details['Balance'];
                                $bureau_account->no_of_months = $bu_account_details['No. of Months (terms)'];
                                $bureau_account->high_credit = $bu_account_details['High Credit'];
                                $bureau_account->credit_limit = $bu_account_details['Credit Limit'];
                                $bureau_account->past_due = $bu_account_details['Past Due'];
                                $bureau_account->payment_status = $bu_account_details['Payment Status'];
                                $bureau_account->last_reported = $bu_account_details['Last Reported'];
                                $bureau_account->comments = $bu_account_details['Comments'];
                                $bureau_account->date_last_active = $bu_account_details['Date Last Active'];
                                $bureau_account->date_of_last_payment = $bu_account_details['Date of Last Payment'];
                                $bureau_account->Save();
                            }


                            if(isset($account['Equifax'])){
                                $bureau = Bureau::where('title', 'Equifax')->orWhere('slug','equifax')->first();

                                $bu_account_details = $account['Equifax'];
                                $bureau_account = new BureauReportAccount();
                                $bureau_account->bureau_report_id = $report->id;
                                $bureau_account->bureau_id = $bureau->id;
                                $bureau_account->client_id = 3;
                                $bureau_account->bureau_account_title_id = $account_title->id;
                                $bureau_account->account = $bu_account_details['Account #'];
                                $bureau_account->account_type = $bu_account_details['Account Type'];
                                $bureau_account->account_type_detail = $bu_account_details['Account Type - Detail'];
                                $bureau_account->bureau_code = $bu_account_details['Bureau Code'];
                                $bureau_account->account_status = $bu_account_details['Account Status'];
                                $bureau_account->monthly_payment = $bu_account_details['Monthly Payment'];
                                $bureau_account->date_opened = $bu_account_details['Date Opened'];
                                $bureau_account->balance = $bu_account_details['Balance'];
                                $bureau_account->no_of_months = $bu_account_details['No. of Months (terms)'];
                                $bureau_account->high_credit = $bu_account_details['High Credit'];
                                $bureau_account->credit_limit = $bu_account_details['Credit Limit'];
                                $bureau_account->past_due = $bu_account_details['Past Due'];
                                $bureau_account->payment_status = $bu_account_details['Payment Status'];
                                $bureau_account->last_reported = $bu_account_details['Last Reported'];
                                $bureau_account->comments = $bu_account_details['Comments'];
                                $bureau_account->date_last_active = $bu_account_details['Date Last Active'];
                                $bureau_account->date_of_last_payment = $bu_account_details['Date of Last Payment'];
                                $bureau_account->Save();
                            }

                            $payment_histories  = $account['Payment History'];
                            foreach($payment_histories as $payment_history){
                                $history_tu = $payment_history['TransUnion'];
                                $history_exp = $payment_history['Experian'];
                                $history_eqfx = $payment_history['Equifax'];

                                if($history_tu == '30' || $history_tu == '60' || $history_tu == '90' || $history_tu == '120' ||
                                    $history_tu == '150' || $history_tu == '180'){
                                    $history_tu  = 'LP';
                                }

                                if($history_exp == '30' || $history_exp == '60' || $history_exp == '90' || $history_exp == '120' ||
                                    $history_exp == '150' || $history_exp == '180'){
                                    $history_exp  = 'LP';
                                }

                                if($history_eqfx == '30' || $history_eqfx == '60' || $history_eqfx == '90' || $history_eqfx == '120' ||
                                    $history_eqfx == '150' || $history_eqfx == '180'){
                                    $history_eqfx  = 'LP';
                                }

                                $bu_payment_history = new BureauReportAccountHistory();
                                $bu_payment_history->bureau_report_id = $report->id;
                                $bu_payment_history->bureau_account_title_id = $account_title->id;
                                $bu_payment_history->month = $payment_history['Month'];
                                $bu_payment_history->year = $payment_history['Year'];
                                $bu_payment_history->transunion = $history_tu;
                                $bu_payment_history->experian = $history_exp;
                                $bu_payment_history->equifax = $history_eqfx;
                                $bu_payment_history->save();

                            }
                        }
                        DB::commit();

                        return redirect()->route('client.credit.profile',['tab'=>'import'])->with('success', "Please look into the report section the report is updated.");
                    }else{
                        $log = new ApiLog();
                        $log->message = 'Report already exist';
                        $log->description = 'Report already exist report id: '.$report->id;
                        $log->came_on = 'Report already exist';
                        $log->save();

                        return redirect()->route('client.credit.profile',['tab'=>'import'])->with('error', 'Latest report already exist please look into the report section.');
                    }

                }else{
                    $log = new ApiLog();
                    $log->message = 'Invalid Status Code';
                    $log->description = 'Invalid Status Code';
                    $log->came_on = 'on identity api';
                    $log->save();
                }

                return redirect()->route('client.credit.profile',['tab'=>'import'])->with('error', 'Something went wrong, Please try later or import report again with the valid identity iq credentials.');
            } catch (\Exception $e) {
                $log = new ApiLog();
                $log->message = 'oops api exception';
                $log->description = $e->getMessage();
                $log->came_on = 'on identity api exception';
                $log->save();

                return redirect()->route('client.credit.profile',['tab'=>'import'])->with('error', 'Something went wrong, Please try later or import report again with the valid identity iq credentials.');
            }

            //            $job = new GetCreditReport($id);
//            dispatch($job);
//            return redirect()->route('client.credit.profile',['tab'=>'import'])->with('success', "Please look into the report section the report is updated.");
        }else{
            return redirect()->route('client.credit.profile',['tab'=>'import'])->with('error', 'Please provide IdentityIQ the credentials of client along with last 4 digit of ssn in order to import the credit report.');
        }
    }

    public function generateBureauDisputeLetters($reasons, $client, $type, $tracking){

        foreach ($reasons as $reason =>$values ){

            $reason= Reason::where('id',$reason)->with('flow')->where('status',1)->first();

            $user_flow  = null;
            $admin_flow = null;

            $bureau_letter = null;

            if(!is_null($reason->flow->where('user_id',1)->first())){
                $admin_flow = $reason->flow->where('user_id',1)->first();

            }
            if(!is_null($reason->flow->where('user_id',auth()->user()->id)->first())){
                $user_flow = $reason->flow->where('user_id',auth()->user()->id)->first();

            }

            if(!is_null($user_flow)){
                $bureau_letter  = $user_flow->bureauLetter;
            }elseif(!is_null($admin_flow)){
                $bureau_letter  = $admin_flow->bureauLetter;
            }

            $dt = Carbon::now();
            $dt->toDayDateTimeString();
            $city = $client->city;
            $state = $client->state;
            $zip_code = $client->zip_code;
            $address = $client->mailing_address;
            $full_name = $client->first_name .' '. $client->last_name;
            $dob = $client->dob;
            $ssn = $client->last_four_ssn;
            $phone = $client->phone;

            $bureau_name = '';
            $bureau_address = '';
            if($type == 'TU'){
                $bureau_name = 'TransUnion';
                $bureau_address = 'TransUnion Consumer Solutions'. ' <br>' .'P.O. Box 2000'. ' <br> ' . 'Chester, PA 19016-2000';
            }elseif($type == 'EXP'){
                $bureau_name = 'Experian';
                $bureau_address = 'Experian'. ' <br>' .'P.O. Box 4500'. ' <br> ' . 'Allen, TX 75013';
            }elseif($type == 'EQFX'){
                $bureau_name = 'Equifax';
                $bureau_address = 'Equifax Information Services, LLC'. ' <br>' .'P.O. Box 740256'. ' <br> ' . 'Atlanta, GA 30374';

            }
            if(!is_null($bureau_letter)){
                $letter = $bureau_letter->letter;
                $letter = str_replace('[BUREAU_NAME]',$bureau_name, $letter);
                $letter = str_replace('[BUREAU_ADDRESS]',$bureau_address, $letter);

                $letter = str_replace('[DATE]',$dt, $letter);
                $letter = str_replace('[CITY]',$city, $letter);
                $letter = str_replace('[STATE]',$state, $letter);
                $letter = str_replace('[ZIP_CODE]',$zip_code, $letter);
                $letter = str_replace('[ADDRESS]',$address, $letter);
                $letter = str_replace('[FULL_NAME]',$full_name, $letter);
                $letter = str_replace('[ACCOUNT_NAME]',$full_name, $letter);
                $letter = str_replace('[DATE_OF_BIRTH]',$dob, $letter);
                $letter = str_replace('[SSN]',$ssn, $letter);
                $letter = str_replace('[PHONE_NUMBER]',$phone, $letter);
                $letter = str_replace('[DISPUTE_REASON]',$reason->title, $letter);

                if($bureau_letter->bulk_letters == 1){
                    $account_numbers_list = '';
                    $account_info_list = '';
                    $furnisher_name_list = '';
                    $furnisher_address_list  = '';
                    foreach ($values as $value){

                        $get_dispute = Dispute::find($value);
                        $get_dispute_history = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',1)->first();
                        $account_detail = 'Account No: '.$get_dispute_history->account. ' <br>';
                        $account_detailinfo = 'Account No: '.$get_dispute_history->account. ' <br>'. 'Furnisher: '. $get_dispute->creditorContact->creditor_name . ' <br> '. 'Furnisher Address: '. $get_dispute->creditorContact->address . ' <br> <br>';
                        $furnisher_name= $get_dispute->creditorContact->creditor_name .'<br>';
                        $furnisher_address = $get_dispute->creditorContact->addresss .'<br>';

                        $account_numbers_list  .= $account_detail;
                        $account_info_list  .= $account_detailinfo;
                        $furnisher_name_list .= $furnisher_name;
                        $furnisher_address_list .= $furnisher_address;
                    }
                    $letter = str_replace('[ACCOUNT_NUMBERS_LIST]',$account_info_list, $letter);
                    $letter = str_replace('[ACCOUNT_NUMBER]',$account_info_list, $letter);
                    $letter = str_replace('[ACCOUNTS_INFO_LIST]',$account_info_list, $letter);
                    $letter = str_replace('[FURNISHER_NAME]',$furnisher_name_list, $letter);
                    $letter = str_replace('[FURNISHER_ADDRESS]',$furnisher_address_list, $letter);

                    $dispute_letter = new DisputeLetter();
                    $dispute_letter->dispute_uid = $tracking;
                    $dispute_letter->owner_id = auth()->user()->id;
                    $dispute_letter->client_id = $client->id;
                    $dispute_letter->company = $bureau_name;
                    $dispute_letter->letter = $letter;
                    $dispute_letter->save();

                }else{

                    foreach ($values as $value){

                        $get_dispute = Dispute::find($value);
                        $get_dispute_history = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',1)->first();
                        $account_detail = 'Account No: '.$get_dispute_history->account. ' <br>';
                        $account_detailinfo = 'Account No: '.$get_dispute_history->account. ' <br>'. 'Furnisher: '. $get_dispute->creditorContact->creditor_name . ' <br> '. 'Furnisher Address: '. $get_dispute->creditorContact->address . ' <br> <br>';
                        $furnisher_name= $get_dispute->creditorContact->creditor_name .'<br>';
                        $furnisher_address = $get_dispute->creditorContact->addresss .'<br>';



                        $letter = str_replace('[ACCOUNT_NUMBERS_LIST]',$account_detail, $letter);
                        $letter = str_replace('[ACCOUNT_NUMBER]',$account_detail, $letter);
                        $letter = str_replace('[ACCOUNTS_INFO_LIST]',$account_detailinfo, $letter);
                        $letter = str_replace('[FURNISHER_NAME]',$furnisher_name, $letter);
                        $letter = str_replace('[FURNISHER_ADDRESS]',$furnisher_address, $letter);

                        $dispute_letter = new DisputeLetter();
                        $dispute_letter->dispute_uid = $tracking;
                        $dispute_letter->owner_id = auth()->user()->id;
                        $dispute_letter->client_id = $client->id;
                        $dispute_letter->company = $bureau_name;
                        $dispute_letter->letter = $letter;
                        $dispute_letter->save();
                    }

                }
            }

        }
    }

    public function generateCreditorDisputeLetters($reasons, $client, $type, $tracking){

        foreach ($reasons as $reason =>$values ){

            $reason= Reason::where('id',$reason)->with('flow')->where('status',1)->first();

            $user_flow  = null;
            $admin_flow = null;

            $furnisher_letter = null;

            if(!is_null($reason->flow->where('user_id',1)->first())){
                $admin_flow = $reason->flow->where('user_id',1)->first();

            }
            if(!is_null($reason->flow->where('user_id',auth()->user()->id)->first())){
                $user_flow = $reason->flow->where('user_id',auth()->user()->id)->first();

            }

            if(!is_null($user_flow)){
                $furnisher_letter =  $user_flow->furnisherLetter;
            }elseif(!is_null($admin_flow)){
                $furnisher_letter =  $admin_flow->furnisherLetter;
            }

            $dt = Carbon::now();
            $dt->toDayDateTimeString();
            $city = $client->city;
            $state = $client->state;
            $zip_code = $client->zip_code;
            $address = $client->mailing_address;
            $full_name = $client->first_name .' '. $client->last_name;
            $dob = $client->dob;
            $ssn = $client->last_four_ssn;
            $phone = $client->phone;

            if(!is_null($furnisher_letter)){
                $letter = $furnisher_letter->letter;

                $letter = str_replace('[DATE]',$dt, $letter);
                $letter = str_replace('[CITY]',$city, $letter);
                $letter = str_replace('[STATE]',$state, $letter);
                $letter = str_replace('[ZIP_CODE]',$zip_code, $letter);
                $letter = str_replace('[ADDRESS]',$address, $letter);
                $letter = str_replace('[FULL_NAME]',$full_name, $letter);
                $letter = str_replace('[ACCOUNT_NAME]',$full_name, $letter);
                $letter = str_replace('[DATE_OF_BIRTH]',$dob, $letter);
                $letter = str_replace('[SSN]',$ssn, $letter);
                $letter = str_replace('[PHONE_NUMBER]',$phone, $letter);
                $letter = str_replace('[DISPUTE_REASON]',$reason->title, $letter);

                if($furnisher_letter->bulk_letters == 1){

                    $credtior_contacts = [];
                    foreach ($values as $value){
                        $get_dispute = Dispute::find($value);
                        if(array_key_exists($get_dispute->bureau_creditor_contact_id,$credtior_contacts)){
                            $credtior_contacts[$get_dispute->bureau_creditor_contact_id] [] = $value;
                        }else{
                            $credtior_contacts[$get_dispute->bureau_creditor_contact_id] = array();
                            $credtior_contacts[$get_dispute->bureau_creditor_contact_id] [] = $value;
                        }
                    }

                    foreach ($credtior_contacts as $contact => $values){
                        foreach ($values as $value){

                            $get_dispute = Dispute::find($value);
                            $get_dispute_history = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',1)->first();
                            $account_detail = 'Account No: '.$get_dispute_history->account. ' <br>';
                            $account_detailinfo = 'Account No: '.$get_dispute_history->account. ' <br>'. 'Furnisher: '. $get_dispute->creditorContact->creditor_name . ' <br> '. 'Furnisher Address: '. $get_dispute->creditorContact->address . ' <br> <br>';
                            $furnisher_name= $get_dispute->creditorContact->creditor_name;
                            $furnisher_address = $get_dispute->creditorContact->addresss;
                            $bureau_name = '';
                            $bureau_address = '';

                            if($get_dispute->is_tu == 1){
                                $bureau_name .= 'TransUnion ';
                                $bureau_address .= 'TransUnion Consumer Solutions'. ' <br>' .'P.O. Box 2000'. ' <br> ' . 'Chester, PA 19016-2000 ';

                            }

                            if($get_dispute->is_exp == 1){
                                $bureau_name .= 'Experian ';
                                $bureau_address .= 'Experian'. ' <br>' .'P.O. Box 4500'. ' <br> ' . 'Allen, TX 75013 ';
                            }

                            if($get_dispute->is_eqfx == 1){
                                $bureau_name .= 'Equifax';
                                $bureau_address .= 'Equifax Information Services, LLC'. ' <br>' .'P.O. Box 740256'. ' <br> ' . 'Atlanta, GA 30374';

                            }

                        }

                        $letter = str_replace('[ACCOUNT_NUMBERS_LIST]',$account_detail, $letter);
                        $letter = str_replace('[ACCOUNT_NUMBER]',$account_detail, $letter);
                        $letter = str_replace('[ACCOUNTS_INFO_LIST]',$account_detailinfo, $letter);
                        $letter = str_replace('[FURNISHER_NAME]',$furnisher_name, $letter);
                        $letter = str_replace('[FURNISHER_ADDRESS]',$furnisher_address, $letter);

                        $letter = str_replace('[FURNISHER_NAME]',$furnisher_name, $letter);
                        $letter = str_replace('[FURNISHER_ADDRESS]',$furnisher_address, $letter);

                        $letter = str_replace('[BUREAU_NAME]',$bureau_name, $letter);
                        $letter = str_replace('[BUREAU_ADDRESS]',$bureau_address, $letter);
                        $dispute_letter = new DisputeLetter();
                        $dispute_letter->dispute_uid = $tracking;
                        $dispute_letter->owner_id = auth()->user()->id;
                        $dispute_letter->client_id = $client->id;
                        $dispute_letter->company = $furnisher_name;
                        $dispute_letter->letter = $letter;
                        $dispute_letter->save();
                    }
                }else{

                    foreach ($values as $value){

                        $get_dispute = Dispute::find($value);
                        $get_dispute_history = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',1)->first();
                        $account_detail = 'Account No: '.$get_dispute_history->account. ' <br>';
                        $account_detailinfo = 'Account No: '.$get_dispute_history->account. ' <br>'. 'Furnisher: '. $get_dispute->creditorContact->creditor_name . ' <br> '. 'Furnisher Address: '. $get_dispute->creditorContact->address . ' <br> <br>';
                        $furnisher_name= $get_dispute->creditorContact->creditor_name;
                        $furnisher_address = $get_dispute->creditorContact->addresss;

                        $bureau_name = '';
                        $bureau_address = '';

                        if($get_dispute->is_tu == 1){
                            $bureau_name .= 'TransUnion ';
                            $bureau_address .= 'TransUnion Consumer Solutions'. ' <br>' .'P.O. Box 2000'. ' <br> ' . 'Chester, PA 19016-2000 ';

                        }

                        if($get_dispute->is_exp == 1){
                            $bureau_name .= 'Experian ';
                            $bureau_address .= 'Experian'. ' <br>' .'P.O. Box 4500'. ' <br> ' . 'Allen, TX 75013 ';
                        }

                        if($get_dispute->is_eqfx == 1){
                            $bureau_name .= 'Equifax';
                            $bureau_address .= 'Equifax Information Services, LLC'. ' <br>' .'P.O. Box 740256'. ' <br> ' . 'Atlanta, GA 30374';

                        }

                        $letter = str_replace('[ACCOUNT_NUMBERS_LIST]',$account_detail, $letter);
                        $letter = str_replace('[ACCOUNT_NUMBER]',$account_detail, $letter);
                        $letter = str_replace('[ACCOUNTS_INFO_LIST]',$account_detailinfo, $letter);
                        $letter = str_replace('[FURNISHER_NAME]',$furnisher_name, $letter);
                        $letter = str_replace('[FURNISHER_ADDRESS]',$furnisher_address, $letter);

                        $letter = str_replace('[BUREAU_NAME]',$bureau_name, $letter);
                        $letter = str_replace('[BUREAU_ADDRESS]',$bureau_address, $letter);

                        $dispute_letter = new DisputeLetter();
                        $dispute_letter->dispute_uid = $tracking;
                        $dispute_letter->owner_id = auth()->user()->id;
                        $dispute_letter->client_id = $client->id;
                        $dispute_letter->company = $furnisher_name;
                        $dispute_letter->letter = $letter;
                        $dispute_letter->save();
                    }
                }
            }

        }
    }

    public function generateAgencyDisputeLetters($reasons, $client, $type, $tracking){

        foreach ($reasons as $reason =>$values ){

            $reason= Reason::where('id',$reason)->with('flow')->where('status',1)->first();

            $user_flow  = null;
            $admin_flow = null;

            $agency_letter = null;

            if(!is_null($reason->flow->where('user_id',1)->first())){
                $admin_flow = $reason->flow->where('user_id',1)->first();

            }
            if(!is_null($reason->flow->where('user_id',auth()->user()->id)->first())){
                $user_flow = $reason->flow->where('user_id',auth()->user()->id)->first();

            }

            if(!is_null($user_flow)){
                $agency_letter =  $user_flow->collectionAgencyLetter;
            }elseif(!is_null($admin_flow)){
                $agency_letter =  $admin_flow->collectionAgencyLetter;
            }

            $dt = Carbon::now();
            $dt->toDayDateTimeString();
            $city = $client->city;
            $state = $client->state;
            $zip_code = $client->zip_code;
            $address = $client->mailing_address;
            $full_name = $client->first_name .' '. $client->last_name;
            $dob = $client->dob;
            $ssn = $client->last_four_ssn;
            $phone = $client->phone;

            if(!is_null($agency_letter)){
                $letter = $agency_letter->letter;

                $letter = str_replace('[DATE]',$dt, $letter);
                $letter = str_replace('[CITY]',$city, $letter);
                $letter = str_replace('[STATE]',$state, $letter);
                $letter = str_replace('[ZIP_CODE]',$zip_code, $letter);
                $letter = str_replace('[ADDRESS]',$address, $letter);
                $letter = str_replace('[FULL_NAME]',$full_name, $letter);
                $letter = str_replace('[ACCOUNT_NAME]',$full_name, $letter);
                $letter = str_replace('[DATE_OF_BIRTH]',$dob, $letter);
                $letter = str_replace('[SSN]',$ssn, $letter);
                $letter = str_replace('[PHONE_NUMBER]',$phone, $letter);
                $letter = str_replace('[DISPUTE_REASON]',$reason->title, $letter);

                if($agency_letter->bulk_letters == 1){
                    $account_numbers_list = '';
                    $account_info_list = '';
                    $furnisher_name_list = '';
                    $furnisher_address_list  = '';
                    $bureau_name = '';
                    $bureau_address = '';

                    foreach ($values as $value){

                        $get_dispute = Dispute::find($value);
                        $get_dispute_history = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',1)->first();
                        $account_detail = 'Account No: '.$get_dispute_history->account. ' <br>';
                        $account_detailinfo = 'Account No: '.$get_dispute_history->account. ' <br>'. 'Furnisher: '. $get_dispute->creditorContact->creditor_name . ' <br> '. 'Furnisher Address: '. $get_dispute->creditorContact->address . ' <br> <br>';
                        $furnisher_name= $get_dispute->creditorContact->creditor_name .'<br>';
                        $furnisher_address = $get_dispute->creditorContact->addresss .'<br>';

                        $account_numbers_list  .= $account_detail;
                        $account_info_list  .= $account_detailinfo;
                        $furnisher_name_list .= $furnisher_name;
                        $furnisher_address_list .= $furnisher_address;

                        if($get_dispute->is_tu == 1){
                            $bureau_name .= 'TransUnion ';
                            $bureau_address .= 'TransUnion Consumer Solutions'. ' <br>' .'P.O. Box 2000'. ' <br> ' . 'Chester, PA 19016-2000 ';

                        }

                        if($get_dispute->is_exp == 1){
                            $bureau_name .= 'Experian ';
                            $bureau_address .= 'Experian'. ' <br>' .'P.O. Box 4500'. ' <br> ' . 'Allen, TX 75013 ';
                        }

                        if($get_dispute->is_eqfx == 1){
                            $bureau_name .= 'Equifax';
                            $bureau_address .= 'Equifax Information Services, LLC'. ' <br>' .'P.O. Box 740256'. ' <br> ' . 'Atlanta, GA 30374';

                        }
                    }
                    $letter = str_replace('[ACCOUNT_NUMBERS_LIST]',$account_info_list, $letter);
                    $letter = str_replace('[ACCOUNT_NUMBER]',$account_info_list, $letter);
                    $letter = str_replace('[ACCOUNTS_INFO_LIST]',$account_info_list, $letter);
                    $letter = str_replace('[FURNISHER_NAME]',$furnisher_name_list, $letter);
                    $letter = str_replace('[FURNISHER_ADDRESS]',$furnisher_address_list, $letter);

                    $letter = str_replace('[BUREAU_NAME]',$bureau_name, $letter);
                    $letter = str_replace('[BUREAU_ADDRESS]',$bureau_address, $letter);

                    $dispute_letter = new DisputeLetter();
                    $dispute_letter->dispute_uid = $tracking;
                    $dispute_letter->owner_id = auth()->user()->id;
                    $dispute_letter->client_id = $client->id;
                    $dispute_letter->company = ucfirst($agency_letter->title);
                    $dispute_letter->letter = $letter;
                    $dispute_letter->save();
                }else{

                    foreach ($values as $value){

                        $get_dispute = Dispute::find($value);
                        $get_dispute_history = $get_dispute->accountHistory->accountTitle->accounts->where('bureau_id',1)->first();
                        $account_detail = 'Account No: '.$get_dispute_history->account. ' <br>';
                        $account_detailinfo = 'Account No: '.$get_dispute_history->account. ' <br>'. 'Furnisher: '. $get_dispute->creditorContact->creditor_name . ' <br> '. 'Furnisher Address: '. $get_dispute->creditorContact->address . ' <br> <br>';
                        $furnisher_name= $get_dispute->creditorContact->creditor_name;
                        $furnisher_address = $get_dispute->creditorContact->addresss;

                        $bureau_name = '';
                        $bureau_address = '';

                        if($get_dispute->is_tu == 1){
                            $bureau_name .= 'TransUnion ';
                            $bureau_address .= 'TransUnion Consumer Solutions'. ' <br>' .'P.O. Box 2000'. ' <br> ' . 'Chester, PA 19016-2000 ';

                        }

                        if($get_dispute->is_exp == 1){
                            $bureau_name .= 'Experian ';
                            $bureau_address .= 'Experian'. ' <br>' .'P.O. Box 4500'. ' <br> ' . 'Allen, TX 75013 ';
                        }

                        if($get_dispute->is_eqfx == 1){
                            $bureau_name .= 'Equifax';
                            $bureau_address .= 'Equifax Information Services, LLC'. ' <br>' .'P.O. Box 740256'. ' <br> ' . 'Atlanta, GA 30374';

                        }

                        $letter = str_replace('[ACCOUNT_NUMBERS_LIST]',$account_detail, $letter);
                        $letter = str_replace('[ACCOUNT_NUMBER]',$account_detail, $letter);
                        $letter = str_replace('[ACCOUNTS_INFO_LIST]',$account_detailinfo, $letter);
                        $letter = str_replace('[FURNISHER_NAME]',$furnisher_name, $letter);
                        $letter = str_replace('[FURNISHER_ADDRESS]',$furnisher_address, $letter);

                        $letter = str_replace('[BUREAU_NAME]',$bureau_name, $letter);
                        $letter = str_replace('[BUREAU_ADDRESS]',$bureau_address, $letter);

                        $dispute_letter = new DisputeLetter();
                        $dispute_letter->dispute_uid = $tracking;
                        $dispute_letter->owner_id = auth()->user()->id;
                        $dispute_letter->client_id = $client->id;
                        $dispute_letter->company = ucfirst($agency_letter->title);
                        $dispute_letter->letter = $letter;
                        $dispute_letter->save();
                    }
                }
            }

        }
    }
}
