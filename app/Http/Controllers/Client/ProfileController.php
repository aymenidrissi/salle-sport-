<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        return view('client.profile');
    }

    public function update(Request $request): RedirectResponse
    {
        return redirect()->route('client.profile');
    }
}
