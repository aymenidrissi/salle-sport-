<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('client.home');
    }

    public function about(): View
    {
        return view('client.about');
    }

    public function contact(): View
    {
        return view('client.contact');
    }
}
