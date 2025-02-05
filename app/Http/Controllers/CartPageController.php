<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartPageController extends Controller
{
    public function index() {
        $products = Session::get('cart', []);
        return view('pages.cart', compact('products'));
    }
}
