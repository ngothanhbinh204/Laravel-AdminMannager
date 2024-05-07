<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $template = 'frontend.client.shop.index';
        return view('frontend.client.layout', compact(
            'template'
        ));
    }
}
