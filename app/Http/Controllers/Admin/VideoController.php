<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
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
        return view('admin.videos.create', [
            'programs' => Program::query()->orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        Video::query()->create($data);

        return redirect()->route('admin.videos.index');
    }

    public function show(Video $video): View
    {
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video): View
    {
        return view('admin.videos.edit', [
            'video' => $video,
            'programs' => Program::query()->orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function update(Request $request, Video $video): RedirectResponse
    {
        $data = $this->validatedData($request);
        $video->update($data);

        return redirect()->route('admin.videos.index');
    }

    public function destroy(Video $video): RedirectResponse
    {
        $video->delete();

        return redirect()->route('admin.videos.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'program_id' => ['nullable', 'exists:programs,id'],
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
    }
}
