<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\User;


class DebtController extends Controller
{
    public function index() {
        $page = 'Debt Reduction Calculator';
        $setting = BusinessSetting::where('type','theme')->first();
        if(!is_null($setting)){
            if($setting->value == 'dark'){
                return view('business.debt.index', compact('page'));
            }else{
                abort(404);
            }
        }else{
            abort(404);
        }
    }
}
