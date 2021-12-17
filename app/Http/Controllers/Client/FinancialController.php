<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;


class FinancialController extends Controller
{
    public function index() {
        $page = 'FINANCIAL CALCULATOR';
        return view('client.financial.index', compact('page'));
    }
}
