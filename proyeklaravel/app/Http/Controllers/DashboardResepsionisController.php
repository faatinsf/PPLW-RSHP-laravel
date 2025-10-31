<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardResepsionisController;

class DashboardResepsionisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('resepsionis.dashboard');
    }
}