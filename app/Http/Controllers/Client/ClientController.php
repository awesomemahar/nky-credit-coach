<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BureauReport;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    //
    public function index()
    {
        $page = 'Dashboard';

        for ($i =5; $i >= 0; $i--) {
            $months[] = date("M", strtotime( date( 'Y-m-01' )." -$i months"));
        }

        for ($i =5; $i >= 0; $i--) {
            $monthsNum[] = date("m", strtotime( date( 'Y-m-01' )." -$i months"));
        }

        $monthly_users = DB::table('disputes')
            ->select(DB::raw('count(id) as total'), DB::raw('MONTH(created_at) as month'),DB::raw('ifnull(count(id),0) as total'))
            ->where("created_at",">", Carbon::now()->subMonths(6))
            ->where('owner_id',auth()->user()->id)
            ->groupBy('month')
            ->get();


        $monthly_vals = [];
        foreach ($monthsNum as $month) {
            $flag = false; // init flag if no month found in montly assessment
            foreach($monthly_users as $data) {
                if ($data->month == $month) { // if found add to the list
                    $monthly_vals [] = $data->total;
                    $flag = true;
                    break; // break the loop once it found match result
                }
            }

            if(!$flag) {
                $monthly_vals [] = 0; // if not found, store as 0
            }
        }
        return view('client.index', compact('page','months','monthly_vals'));
    }

    public function profile(){
        $page = 'Profile';
        $client  = auth()->user();
        return view('client.profile', compact('page','client'));
    }

    public function profilePost(Request $request){
        $page = 'Profile';
        $user = auth()->user();
        $rules =  [
            'first_name' => 'required|max:250',
            'last_name'=>'required|max:250',
            'email'=>'required|email|max:250|unique:users,email,' . $user->id . ',id',
            'dob' => 'required|max:20',
            'phone'=>'required|max:25',
            'mailing_address'=>'required',
            'city' => 'required|max:50',
            'state'=>'required|max:50',
            'zip_code'=>'required|max:25',
        ];

        $user = auth()->user();

        if($user->picture === null || !is_null($request->picture)){
            $rules['picture'] = 'required|image|mimes:jpg,png,jpeg,gif|max:2048';
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
            $data = $request->except('picture');
            if(!is_null($user)){
                $data['no_email_check'] = ($request->no_email_check) ? 1 : 0;
                $data['password'] = ($request->password) ? Hash::make($request->password) : $user->password;
                $user->update($data);

                if($request->has('picture')){
                    $image=$request->file('picture');

                    $image_name='_DP_'.time();
                    $ext=strtolower($image->getClientOriginalExtension());
                    $image_full_name=$image_name.'.'.$ext;
                    $upload_path='assets/business/img/profiles/';
                    $image_url=$upload_path.$image_full_name;
                    $success=$image->move($upload_path,$image_full_name);
                    if ($success) {
                        if(file_exists($user->picture)){
                            unlink($user->picture);
                        }
                        $user->picture = $image_url;
                        $user->save();
                    }
                }
                DB::commit();
                return back()->with('success', 'Client Updated Successfully');
            }else{
                return back()->with('error', 'Something Went Wrong');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }

    public function updateCredentials(Request  $request){
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
            $client = auth()->user();
            $client->update($data);
            DB::commit();
            return redirect()->route('client.credit.profile',['tab'=>'import'])->with('success', 'Information updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('client.credit.profile',['tab'=>'import'])->with('error', 'Something went wrong');
        }
    }

    public function lettersLibrary()
    {
        $page = 'Letters Library';
        return view('client.pages.letters-library', compact('page'));
    }

    public function trainingVideos()
    {
        $page = 'Training Videos';
        $videos = Video::whereStatus(1)->orderBy('id', 'desc')->get();
        return view('client.pages.training-videos', compact('page','videos'));
    }

    public function showTrainingVideo($id){
        $page = 'Training Videos';
        $video = Video::whereStatus(1)->where('id',$id)->first();
        if(!is_null($video)){
            $page = 'Training Videos';
            return view('client.pages.training-video-show', compact('page', 'video'));
        }else{
            return back()->with('error', 'Something Went Wrong');
        }
    }

    public function creditProfile(Request  $request)
    {
        $page = 'Credit Profile Dashboard';
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
        $client = auth()->user();
        $report = BureauReport::where('client_id',$client->id)->orderBy('id')->first();
        return view('client.pages.client-profile', compact('page', 'client','tab','report'));
//        return view('client.pages.client-profile', compact('page'));
    }

    public function financialCalculator()
    {
        $page = 'Financial Calculator';
        return view('client.pages.financial-calculator', compact('page'));
    }

    public function calendar()
    {
        $page = 'My Calendar';
        return view('client.pages.calendar', compact('page'));
    }
}
