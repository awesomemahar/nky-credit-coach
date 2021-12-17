<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Models\User;


class CalendarController extends Controller
{
    public function index() {
        $page = 'My Calendar';
        $clients = User::where('type', 3)->get();
        $reminders = Reminder::where('owner_id',auth()->user()->id)->get();
        return view('business.calendar.index', compact('page', 'clients', 'reminders'));
    }
}
