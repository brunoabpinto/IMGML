<?php

namespace App\Services;

class ImageService
{
    public function render(string $path): string
    {
        $image = $this->resizeImage($path, 200, 200);
        $resource = imagecreatefromjpeg($image);
        $width = imagesx($resource);
        $height = imagesy($resource);
        $pixels = [];

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $color = imagecolorat($resource, $x, $y);
                $rgbArray = imagecolorsforindex($resource, $color);
                $hex = sprintf('#%02x%02x%02x', $rgbArray['red'], $rgbArray['green'], $rgbArray['blue']);
                $pixels[] = $hex;
            }
        }

        if (file_exists($image)) {
            unlink($image);
        }

        return $this->getImageHtml($pixels, $width);
    }

    private function resizeImage($sourcePath, $width, $height)
    {
        $source = imagecreatefromjpeg($sourcePath);
        $thumb = imagecreatetruecolor($width, $height);

        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, imagesx($source), imagesy($source));

        $tempPath = storage_path('app/temp/resized_'.uniqid().'.jpg');
        imagejpeg($thumb, $tempPath);

        return $tempPath;
    }

    public function getImageHtml(array $pixels, int $width): string
    {
        $html = '<style>r{display:flex}hr {width:1px;height:1px;display:inline-block;border:none}</style><r>';

        foreach ($pixels as $key => $pixel) {
            $html .= "<hr color={$pixel}>";
            if ($key % $width == 0) {
                $html .= '</r><r>';
            }
        }

        $html .= '</r>';

        return $html;
    }
}
