<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $title = 'Frequently Asked Questions';
        return view('pages.faq')->with('title', $title);
    }
}
