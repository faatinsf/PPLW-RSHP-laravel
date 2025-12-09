<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPemilikController extends Controller
{
    public function index(){
        return view('pemilik.dashboard');
    }
}
