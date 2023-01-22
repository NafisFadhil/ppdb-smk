<?php

namespace App\Helpers;

class ImageHelper
{
	
	public static function filenameGenerator () {
		return \Nette\Utils\Random::generate(50, '0-9A-Za-z');
	}
	
	public static function uploadAvatar ($file) {
		$fileext = $file->getClientOriginalExtension();
		$filename = static::filenameGenerator();
		$filepath = public_path()."/storage/avatar/$filename.$fileext";
		$imgclass = \Intervention\Image\ImageManagerStatic::configure([ 'driver' => 'imagick']);
		$img = $imgclass->make($file);
		$imgwidth = intval(floor($img->getWidth()));
		$imgheight = intval(floor($img->getHeight()));

		if ($imgwidth < $imgheight) $imgheight = $imgwidth;
		elseif ($imgwidth > $imgheight) $imgwidth = $imgheight;
		
		$img->crop($imgwidth, $imgheight)->resize(200, 200)->save($filepath, 100);
		return "/storage/avatar/$filename.$fileext";
	}

}
