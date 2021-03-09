<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;

class HomeController extends Controller
{
    public function index(){
        $totalOrder = Order::count();
        $totalProduct = Product::count();
        $totalCustomer = Customer::count();
        $orders = Order::with('customer')->limit(5)->latest()->get();

        return view('home', compact('totalOrder', 'orders', 'totalProduct', 'totalCustomer'));
    }
}
