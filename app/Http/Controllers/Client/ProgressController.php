<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function index(): View
    {
        return view('client.progress.index');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('client.progress.index');
    }
}
