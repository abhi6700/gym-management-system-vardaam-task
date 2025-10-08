<?php

namespace App\Http\Controllers\tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{   
    public function __construct()
    {
        if(auth()->user()->role == "admin") {
            abort(401);
        }
    }

    public function index()
    {
        return Inertia::render('tenant/tenant-dashboard');
    }
}
