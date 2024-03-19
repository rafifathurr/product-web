<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\product\Product;
use App\Models\User;

class DashboardControllers extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Index View and Scope Data
    public function index()
    {
        // RETURN DATA
        $data['title'] = "Dashboard";
        $data['total_user'] = count(User::where('deleted_at',null)->get());
        $data['total_user_active'] = count(User::where('deleted_at',null)->where('status', 1)->get());
        $data['total_product'] = count(Product::where('deleted_at',null)->get());
        $data['total_product_active'] = count(User::where('deleted_at',null)->where('status', 1)->get());
           
        // RETURN VIEW
        return view('dashboard', $data);
    }
}
