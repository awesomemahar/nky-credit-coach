<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    //
    public function index()
    {
        $page = 'Dashboard';
        return view('business.index', compact('page'));
    }

    public function profile(){
        $page = 'Profile';
        $client  = auth()->user();
        return view('business.profile', compact('page','client'));
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

    public function clients()
    {
        $page = 'My Clients';
        return view('business.pages.clients', compact('page'));
    }

    public function lettersLibrary()
    {
        $page = 'Letters Library';
        return view('business.pages.letters-library', compact('page'));
    }

    public function trainingVideos()
    {
        $page = 'Training Videos';
        return view('business.pages.training-videos', compact('page'));
    }


    public function addClient(){
        $page = 'My clients';
        return view('business.pages.add-client', compact('page'));
    }

    public function calendar(){
        $page = 'My Calendar';
        return view('business.pages.calendar', compact('page'));
    }

    public function financialCalculator(){
        $page = 'Financial Calculator';
        return view('business.pages.financial-calculator', compact('page'));
    }
}
