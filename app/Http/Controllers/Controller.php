<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public function optimizeImage($file, $type, $w = 720, $h = 405, $q = 80) {
    //     $fileext = $file->getClientOriginalExtension();
    //     $filename = \Nette\Utils\Random::generate(50, '0-9A-Za-z');
    //     $filepath = public_path()."/storage/$type/$filename.$fileext";
    //     $imgclass = new \Intervention\Image\ImageManager;
    //     $img = $imgclass->make($file);
    //     $imgwidth = intval(floor($img->getWidth()));
    //     $imgheight = intval(floor($imgwidth*9/16));
    //     $img->crop($imgwidth, $imgheight)->resize($w, $h)->save($filepath, $q);
    //     return "$type/$filename.$fileext";
    // }
}
