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
    $uploadedFile = $request->file('file');
    $filename = $uploadedFile->hashName();
    $uploadedFile->storeAs('', $filename, 'public');

    $fullPath = storage_path('app/public/' . $filename);

    Image::load($fullPath)
        ->fit(Manipulations::FIT_MAX, 200, 200)
        ->save();

    return Inertia::render('Home', [
        'uploadedImage' => RenderImageService::render($fullPath),
        'path' => $filename
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
