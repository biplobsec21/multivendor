<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    //dashboard
    public function dashboard(){
        return view('vendor.dashboard');

    }
}
