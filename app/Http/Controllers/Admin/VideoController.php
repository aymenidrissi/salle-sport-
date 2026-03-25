<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(): View
    {
        return view('admin.videos.index', [
            'videos' => Video::query()->with('program')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.videos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('admin.videos.index');
    }

    public function show(Video $video): View
    {
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video): View
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video): RedirectResponse
    {
        return redirect()->route('admin.videos.index');
    }

    public function destroy(Video $video): RedirectResponse
    {
        return redirect()->route('admin.videos.index');
    }
}
