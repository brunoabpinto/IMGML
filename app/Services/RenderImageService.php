<?php

namespace App\Services;

class RenderImageService
{
    /**
     * render
     *
     * @param  string $path
     * @param  bool $includeLayout
     * @return string
     */
    public static function render(string $path, bool $includeLayout=false) : string
    {
        $resource = imagecreatefromjpeg($path);
        $width = imagesx($resource);
        $height = imagesy($resource);
        $pixels = [];

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $color = imagecolorat($resource, $x, $y);
                $rgbArray = imagecolorsforindex($resource, $color);
                $rgb = implode(',', array_values(array_slice($rgbArray, 0, 3)));
                $pixels[] = $rgb;
            }
        }
        return view($includeLayout ? 'download' : 'output', ['width' => $width, 'pixels' => $pixels])->render();
    }
}
