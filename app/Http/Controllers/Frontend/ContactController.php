<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $title = 'Trang liên hệ';
        $template = 'frontend.client.contact.index';
        return view('frontend.client.layout', compact(
            'template',
            'title'
        ));
    }
}
