<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;

use App\Jobs\GetCreditReport;
use App\Models\ApiLog;
use App\Models\Bureau;
use App\Models\BureauAccountTitle;
use App\Models\BureauCreditorContact;
use App\Models\BureauReport;
use App\Models\BureauReportAccount;
use App\Models\BureauReportAccountHistory;
use App\Models\BureauReportInquiry;
use App\Models\BureauReportSummary;
use App\Models\ClientDocument;
use App\Models\ReportInformation;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'My Clients';
        $clients = User::where('business_id', auth()->user()->id)->where('type', 3)->get();
        return view('business.client.index', compact('page', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = 'My Clients';
        $user = auth()->user();
        if(isset($user->currentPlan)){

            if($user->clients->count() < $user->currentPlan->no_of_clients){
                return view('business.client.create', compact('page'));
            }else{
                return back()->with('error', 'Snap!, you are done with your clients limit, please upgrade your plan in order to add new client.');
            }
        }else{
            return back()->with('error', 'Snap!, you are done with your clients limit, please upgrade your plan in order to add new client.');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if(isset($user->currentPlan)){
//
            if($user->clients->count() >= $user->currentPlan->no_of_clients) {
                return back()->with('error', 'Snap!, you are done with your clients limit, please upgrade your plan in order to add new client.');
            }
        }
        $rules =  [
            'first_name' => 'required|max:250',
            'last_name'=>'required|max:250',
            'dob' => 'required|max:20',
            'phone'=>'required|max:25',
            'mailing_address'=>'required',
            'city' => 'required|max:50',
            'state'=>'required|max:50',
            'zip_code'=>'required|max:25',
        ];


        if(!$request->no_email_check){
            $rules['email'] = 'required|email|max:250|unique:users,email';
        }


        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $data = $request->all();
            if($request->no_email_check){
                $faker = Factory::create();
                $random_email= $faker->unique()->safeEmail();
                $data['email'] = $random_email;

                if($request->has('email')){
                    $email_exist = User::where('email', $request->get('email'))->first();
                    if(is_null($email_exist)){
                        $faker = Factory::create();
                        $random_email= $faker->unique()->safeEmail();
                        $data['email'] = $random_email;
                    }
                }
            }
            $data['subscription_package_id'] = 1;
            $data['no_email_check'] = ($request->no_email_check) ? 1 : 0;
            $data['password'] = Hash::make('CreditDispute!#%');
            $data['type'] = 3;
            $data['business_id'] = auth()->user()->id;
            User::create($data);
            DB::commit();
            return back()->with('success', 'Client Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = User::where('business_id', auth()->user()->id)->whereId($id)->first();
        if(!is_null($client)){
            $page = 'My Clients';
            return view('business.client.edit', compact('page', 'client'));
        }else{
            return redirect()->route('business.client.index')->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $rules =  [
            'first_name' => 'required|max:250',
            'last_name'=>'required|max:250',
            'dob' => 'required|max:20',
            'phone'=>'required|max:25',
            'mailing_address'=>'required',
            'city' => 'required|max:50',
            'state'=>'required|max:50',
            'zip_code'=>'required|max:25',
        ];


        if(!$request->no_email_check){
            $rules['email'] = 'required|email|max:250|unique:users,email,' . $id . ',id';
        }


        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $data = $request->all();
            $client = User::where('business_id', auth()->user()->id)->whereId($id)->first();
            if(!is_null($client)){
                $data['no_email_check'] = ($request->no_email_check) ? 1 : 0;
                if($request->no_email_check){
                    if(is_null($client->email) || empty($client->email)){
                        $faker = Factory::create();
                        $random_email= $faker->unique()->safeEmail();
                        $data['email'] = $random_email;
                    }

                    if($request->has('email')){
                        $email_exist = User::where('email', $request->get('email'))->where('id','!=', $id)->first();
                        if(is_null($email_exist)){
                            $faker = Factory::create();
                            $random_email= $faker->unique()->safeEmail();
                            $data['email'] = $random_email;
                        }
                    }
                }
                $data['password'] = ($request->password) ? Hash::make($request->password) : $client->password;
                $client->update($data);
                DB::commit();
                return back()->with('success', 'Client Updated Successfully');
            }else{
                return redirect()->route('business.client.index')->with('error', 'Something Went Wrong');
            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $client = User::find($id);
            $client->delete();
            DB::commit();
            return back()->with('success', 'Client Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }

    public function updateClientCredentials(Request $request, $client){
        $id = $client;
        $request->validate(
            [
                'iq_username' => ['required', 'string', 'max:255'],
                'iq_password' => ['required', 'string', 'max:255'],
                'last_four_ssn' => ['required', 'numeric', 'max:9999'],
            ]
        );
        try {
            DB::beginTransaction();
            $data = $request->all();
            $client = User::find($id);
            $client->update($data);
            DB::commit();
            return redirect()->route('business.credit.get.profile',['id'=>$client->id,'tab'=>'import'])->with('success', 'Information updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('business.credit.get.profile',['id'=>$client->id,'tab'=>'import'])->with('error', 'Something went wrong');
        }
    }

    public function clientImportReport($client){
        $id = $client;
        $user = User::findorfail($id);

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
                        return redirect()->route('business.credit.get.profile',['id'=>$user->id,'tab'=>'import'])->with('error', 'Something went wrong, Please try later or import report again with the valid identity iq credentials.');
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

                        return redirect()->route('business.credit.get.profile',['id'=>$user->id,'tab'=>'import'])->with('success', "Please look into the report section the report is updated.");
                    }else{
                        $log = new ApiLog();
                        $log->message = 'Report already exist';
                        $log->description = 'Report already exist report id: '.$report->id;
                        $log->came_on = 'Report already exist';
                        $log->save();

                        return redirect()->route('business.credit.get.profile',['id'=>$user->id,'tab'=>'import'])->with('error', 'Latest report already exist please look into the report section.');
                    }

                }else{
                    $log = new ApiLog();
                    $log->message = 'Invalid Status Code';
                    $log->description = 'Invalid Status Code';
                    $log->came_on = 'on identity api';
                    $log->save();
                }

                return redirect()->route('business.credit.get.profile',['id'=>$user->id,'tab'=>'import'])->with('error', 'Something went wrong, Please try later or import report again with the valid identity iq credentials.');

            } catch (\Exception $e) {
                $log = new ApiLog();
                $log->message = 'oops api exception';
                $log->description = $e->getMessage();
                $log->came_on = 'on identity api exception';
                $log->save();
                return redirect()->route('business.credit.get.profile',['id'=>$user->id,'tab'=>'import'])->with('error', 'Something went wrong, Please try later or import report again with the valid identity iq credentials.');
            }

            //            $job = new GetCreditReport($id);
//            dispatch($job);
//            return redirect()->route('business.credit.get.profile',['id'=>$user->id,'tab'=>'import'])->with('success', "Please look into the report section the report is updated.");
        }else{
            return redirect()->route('business.credit.get.profile',['id'=>$user->id,'tab'=>'import'])->with('error', 'Please provide IdentityIQ the credentials of client along with last 4 digit of ssn in order to import the credit report.');
        }
    }

    public function uploadClientFile (Request $request,$client){
        $owner = auth()->user();
        $request->validate([
            'title' => 'required|max:255',
            'document' => 'required|max:10240',
        ]);

        $file_name_exist = ClientDocument::where('client_id', $client)->where('owner_id',$owner->id)->where('name',$request->title)->first();

        if(!is_null($file_name_exist)){
            return redirect()->back()->with('error', 'This file title already exist, Please upload file with some other title.');
        }

        try {
            $document = new ClientDocument();
            $document->name = $request->title;
            $document->owner_id = $owner->id;
            $document->client_id = $client;
            $document->save();


            if($request->has('document')){
                $file=$request->file('document');

                $ext=strtolower($file->getClientOriginalExtension());
                $full_name='_CLIENT_'.time();
                $upload_path='assets/client/files/';
                $file_url=$upload_path.$full_name;
                $success=$file->move($upload_path,$full_name);
                if ($success) {
                    $document->file_path = $file_url;
                    $document->extension = $file->getClientOriginalExtension();
                    $document->save();
                }else{
                    $document->delete();
                    return redirect()->back()->with('error', 'Something went wrong');
                }

                return redirect()->back()->with('success', "File uploaded successfully.");
            }

            } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }
}
