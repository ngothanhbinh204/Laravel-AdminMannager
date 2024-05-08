<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $title = 'Trang giỏ hàng';
        $template = 'frontend.client.cart.index';
        return view('frontend.client.layout', compact(
            'template',
            'title'
        ));
    }
}
