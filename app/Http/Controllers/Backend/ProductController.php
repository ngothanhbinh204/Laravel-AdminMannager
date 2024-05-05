<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $template = 'backend.product.index';
        $products = Product::all();
        return view('backend.dashboard.layout', compact(
            'template',
            'products'
        ));
    }
    public function create()
    {
    }

    public function store($request)
    {
    }

    public function detail($id)
    {
    }

    public function edit($id)
    {
    }
}