<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RenderImageService;
use Inertia\Inertia;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class ImageController extends Controller
{
    /**
     * Render the homepage
     *
     * @return Inertia\Inertia
     */
    public function index() {
        return Inertia::render('Home', [
            'image' => RenderImageService::render('https://picsum.photos/200/200')
        ]);
    }

    /**
     * Upload an image and return it in HTML format
     *
     * @param  Illuminate\Http\Request $request
     * @return Inertia\Inertia
     */
    public function upload(Request $request)
    {
        $path = $request->file('file')->store('public');
        $path = str_replace('public', 'storage', $path);

        Image::load($path)
        ->fit(Manipulations::FIT_MAX, 200, 200)
        ->save();

        return Inertia::render('Home', [
            'uploadedImage' => RenderImageService::render($path),
            'path' => $path
        ]);
    }

    /**
     * Download image HTML
     *
     * @param  lluminate\Http\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function download(Request $request)
    {
        $html = RenderImageService::render($request->get('path'), true);
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename=imgml.html'),
            'Content-Length' => strlen($html)
        ];
        return response()->make($html, 200, $headers);
    }
}
