<?php

namespace App\Jobs;

use App\Models\ApiLog;
use App\Models\Bureau;
use App\Models\BureauAccountTitle;
use App\Models\BureauCreditorContact;
use App\Models\BureauReport;
use App\Models\BureauReportAccount;
use App\Models\BureauReportAccountHistory;
use App\Models\BureauReportInquiry;
use App\Models\BureauReportSummary;
use App\Models\ReportInformation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class GetCreditReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $client;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($client)
    {
        //
        $this->client = $client;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $user = User::find($this->client);
        $username = $user->iq_username;
        $password = $user->iq_password;
        $ssn = $user->last_four_ssn;

//        dd($credit_score);
        try {

            $client = new \GuzzleHttp\Client();

            $response = $client->post(
                'http://18.222.162.33/getData/',
                array(
                    'form_params' => array(
                        'email' => $username,
                        'password' => $password,
                        'ssn' => $ssn,
                    )
                )
            );
            if($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody()->getContents(),true);
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
                            $bu_payment_history = new BureauReportAccountHistory();
                            $bu_payment_history->bureau_report_id = $report->id;
                            $bu_payment_history->bureau_account_title_id = $account_title->id;
                            $bu_payment_history->month = $payment_history['Month'];
                            $bu_payment_history->year = $payment_history['Year'];
                            $bu_payment_history->transunion = $payment_history['TransUnion'];
                            $bu_payment_history->experian = $payment_history['Experian'];
                            $bu_payment_history->equifax = $payment_history['Equifax'];
                            $bu_payment_history->save();

                        }
                    }
                    DB::commit();
                }else{
                    $log = new ApiLog();
                    $log->message = 'Report already exist';
                    $log->description = 'Report already exist report id: '.$report->id;
                    $log->came_on = 'Report already exist';
                    $log->save();
                }

            }else{
                $log = new ApiLog();
                $log->message = 'Invalid Status Code';
                $log->description = 'Invalid Status Code';
                $log->came_on = 'on identity api';
                $log->save();
            }

        } catch (\Exception $e) {
            $log = new ApiLog();
            $log->message = 'oops api exception';
            $log->description = $e->getMessage();
            $log->came_on = 'on identity api exception';
            $log->save();

        }
    }
}
