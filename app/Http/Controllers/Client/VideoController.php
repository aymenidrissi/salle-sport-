<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function show(Video $video): View
    {
        // Charger le programme associé pour afficher sa présentation.
        $video->load('program');

        return view('client.videos.show', compact('video'));
    }
}
