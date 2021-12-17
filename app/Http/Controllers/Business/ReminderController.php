<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ReminderController extends Controller
{
    public function store(Request $request) {
        $request->validate(['title' => ['required', 'string', 'max:255'], 'time' => ['required'], 'user_id' => ['required'],]);
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['owner_id'] = auth()->user()->id;
            Reminder::create($data);
            DB::commit();
            return back()->with('success', 'Reminder Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }
    public function update(Request $request) {
        $request->validate(['title' => ['required', 'string', 'max:255'], 'time' => ['required'], 'user_id' => ['required'],]);
        try {
            DB::beginTransaction();
            $reminder = Reminder::where('owner_id',\auth()->user()->id)->whereId($request->id)->first();
            if(!is_null($reminder)){
                $data = $request->all();
                $reminder->update($data);
                DB::commit();
                return back()->with('success', 'Reminder Updated Successfully');
            }else{
                return back()->with('error', 'Something Went Wrong');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }
    public function destroy($id) {
        try {
            DB::beginTransaction();
            $reminder = Reminder::where('owner_id',\auth()->user()->id)->whereId($id)->first();
            if(!is_null($reminder)) {
                $reminder->delete();
                DB::commit();
                return back()->with('success', 'Reminder Deleted Successfully');
            }else{
                return back()->with('error', 'Something Went Wrong');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }
}
