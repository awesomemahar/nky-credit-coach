<?php

namespace App\Http\Controllers\Client;

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
            $reminder = Reminder::find($request->id);
            $data = $request->all();
            $reminder->update($data);
            DB::commit();
            return back()->with('success', 'Reminder Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }
    public function destroy($id) {
        try {
            DB::beginTransaction();
            $reminder = Reminder::find($id);
            $reminder->delete();
            DB::commit();
            return back()->with('success', 'Reminder Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }
}
