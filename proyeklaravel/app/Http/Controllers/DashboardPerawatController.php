<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardPerawatController;

class DashboardPerawatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('perawat.dashboard');
    }
}