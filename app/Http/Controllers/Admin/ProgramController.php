<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        return view('admin.programs.index', [
            'programs' => Program::query()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.programs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('admin.programs.index');
    }

    public function show(Program $program): View
    {
        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program): View
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        return redirect()->route('admin.programs.index');
    }

    public function destroy(Program $program): RedirectResponse
    {
        return redirect()->route('admin.programs.index');
    }
}
