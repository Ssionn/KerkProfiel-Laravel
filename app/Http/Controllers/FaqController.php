<?php

namespace App\Http\Controllers;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = auth()->user()->role->faqs()->get();

        return view('faq.index', compact('faqs'));
    }
}
