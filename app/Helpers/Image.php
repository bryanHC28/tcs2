<?php

namespace App\Helpers;

use Intervention\Image\Facades\Image as InterventionImage;

class Image
{
    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * Optimize image and parse to png format
     *
     * @param mixed $image
     * @param Int $width 500
     * @param Int|null $height null
     * @param Int $quality 70
     *
     * @return Intervention\Image\Facades\Image $imageOptimizedPNG
     */
    public static function optimize(mixed $image, Int $width = 500, Int|null $height = null, Int $quality = 70)
    {
        $imageOptimized = InterventionImage::make($image);
        $imageOptimized->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $imageOptimized->encode('png', $quality);
    }
}
