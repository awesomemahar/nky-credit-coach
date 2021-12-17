<?php

namespace App\Http\Controllers;

use Interfax\Client;

class HomeController extends Controller
{
    public function apiTest(){
//        dd(asset('assets/creditrepair.pdf'));
        $interfax = new Client(['username' => 'Newcreditinc1', 'password' => 'Lovely27$']);
        dd('Client Balance:' .$interfax->getBalance());
        $fax = $interfax->deliver(['faxNumber' => '+2518668204', 'file' => asset('assets/creditrepair.pdf')]);

// get the latest status:
        $fax->refresh()->status; // Pending if < 0. Error if > 0

// Simple polling
        while ($fax->refresh()->status < 0) {
            sleep(5);
        }
        dd($fax);
         dd('Client Balance:' .$interfax->getBalance());

    }
}
