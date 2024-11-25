<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('role_id', auth()->user()->role_id)->get();

        return view('faq.index', compact('faqs'));
    }
}
