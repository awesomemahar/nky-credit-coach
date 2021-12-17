<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
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

        $monthly_users = DB::table('users')
            ->select(DB::raw('count(id) as total'), DB::raw('MONTH(created_at) as month'),DB::raw('ifnull(count(id),0) as total'))
            ->where("created_at",">", Carbon::now()->subMonths(6))
            ->where('type','!=',1)
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

        return view('admin.index', compact('page','months','monthly_vals'));
    }

    public function clients()
    {
        $page = 'Manage Clients';
        return view('admin.pages.clients', compact('page'));
    }

    public function profile(){
        $page = 'Profile';
        $client  = auth()->user();
        return view('admin.profile', compact('page','client'));
    }

    public function profilePost(Request $request){
        $page = 'Profile';
        $user = auth()->user();
        $rules =  [
            'first_name' => 'required|max:250',
            'last_name'=>'required|max:250',
            'email'=>'required|email|max:250|unique:users,email,' . $user->id . ',id',
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

    public function lettersLibrary()
    {
        $page = 'Letters Library';
        return view('admin.pages.letters-library', compact('page'));
    }

    public function trainingVideos()
    {
        $page = 'Training Videos';
        return view('admin.pages.training-videos', compact('page'));
    }

    public function subscriptions(){
        $page = 'Subscriptions';
        return view('admin.pages.subscriptions', compact('page'));

    }
    public function subscriptionForms()
    {
        $page = 'Subscription Forms';
        return view('admin.pages.subscriptions-forms', compact('page'));
    }
    public function addSubscriptionForm()
    {
        $page = 'Subscription Forms';
        return view('admin.pages.add-subscription', compact('page'));
    }

    public function creditWizard(){
        $page = 'Credit Wizard';
        return view('admin.pages.credit-wizard', compact('page'));
    }

//    public function addClient(){
//        $page = 'Add client';
//        return view('admin.pages.add-client', compact('page'));
//    }
}
