<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard_admin');
    }

    public function index()
    {
        return view('dashboard');
    }
}
