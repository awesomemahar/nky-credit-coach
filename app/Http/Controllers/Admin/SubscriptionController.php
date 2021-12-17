<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    //

    public function addPackage(){
        $page = 'Add Package';
        return view('admin.packages.add',compact('page'));
    }

    public function packages(){
        $page = 'Subscription Packages';
        $packages = SubscriptionPackage::all();

        return view('admin.packages.packages',compact('packages','page'));
    }
    public function addPackagePost(Request  $request){

        $rules =  [
            'title' => 'required|min:2|max:50',
            'monthly_price'=>'required|numeric',
            'package_type'=>'required',
            'no_of_clients' => 'required_if:package_type,Business|numeric|min:1',
            'picture'=>'required|image|mimes:jpg,png,jpeg,gif|max:2048'
        ];

        if($request->has('per_fax_price') && !is_null(BusinessSetting::where('type','fax_client')->where('value', '1')->first())){
            $rules['per_fax_price'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $package = new SubscriptionPackage();
        $package->title = $request->title;
        $package->monthly_price = $request->monthly_price;
        $package->package_type = $request->package_type;
        if($request->package_type == 'Business'){
            $package->no_of_clients = $request->no_of_clients;
        }

        if($request->has('per_fax_price') && !is_null(BusinessSetting::where('type','fax_client')->where('value', '1')->first())){
            $package->per_fax_price = $request->per_fax_price;
        }
        if($request->has('description')){
            $package->description = $request->description;
        }

        if($request->has('feature')){
            $package->features = json_encode(array_filter($request->get('feature')));
        }

        if($request->has('picture')){
            $image=$request->file('picture');

            $image_name='PKG_'.time();
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='assets/admin/img/packages/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if ($success) {

                $package->picture = $image_url;
                $package->save();
            }
        }

        $package->save();

        return back()->with('success', 'package added successfully.');
    }

    public function editPackage ($id){
        $page = 'Subscription Packages';
        $package = SubscriptionPackage::findorfail($id);

        return view('admin.packages.edit',compact('package','page'));
    }

    public function editPackagePost(Request  $request,$id){


        $rules =  [
            'title' => 'required|min:2|max:50',
            'monthly_price'=>'required|numeric',
        ];

        if($request->has('picture')){
            $rules['picture'] = 'required|image|mimes:jpg,png,jpeg,gif|max:2048';
        }

        if($request->has('per_fax_price') && !is_null(BusinessSetting::where('type','fax_client')->where('value', '1')->first())){
            $rules['per_fax_price'] = 'required|numeric';
        }


        $validator = Validator::make($request->all(),$rules);

        $package = SubscriptionPackage::findorfail($id);

        try{
            $package->title = $request->title;
            $package->monthly_price = $request->monthly_price;

            if($request->has('description')){
                $package->description = $request->description;
            }

            if($request->has('feature')){
                $package->features = json_encode(array_filter($request->get('feature')));
            }

            if($request->has('per_fax_price') && !is_null(BusinessSetting::where('type','fax_client')->where('value', '1')->first())){
                $package->per_fax_price = $request->per_fax_price;
            }

            if($request->has('picture')){
                $image=$request->file('picture');

                $image_name='PKG_'.time();
                $ext=strtolower($image->getClientOriginalExtension());
                $image_full_name=$image_name.'.'.$ext;
                $upload_path='assets/admin/img/packages/';
                $image_url=$upload_path.$image_full_name;
                $success=$image->move($upload_path,$image_full_name);
                if ($success) {
                    if(file_exists($package->picture)){
                        unlink($package->picture);
                    }
                    $package->picture = $image_url;
                    $package->save();
                }
            }

            $package->save();

            return back()->with('success', 'package updated successfully.');
        }catch (\Exception $exception){

        }
    }
}
