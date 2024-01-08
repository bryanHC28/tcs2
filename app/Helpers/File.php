<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class File
{
    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * Name maker
     *
     * @param String $originalNameWithExtension
     *
     * @return String $newName
     */
    public static function createUniqueName(String $originalNameWithExtension)
    {
        return Str::slug(config('app.name') . ' file ' . now()->format('YmdHis') . ' ' . Str::random(12), '_') . $originalNameWithExtension;
    }
}
