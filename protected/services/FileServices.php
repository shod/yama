<?php

class FileServices
{
	public static function createDirectory($dir){
		if(is_dir($dir)){
			return;
		} else {
			@mkdir($dir, 0775, true);
		}
	}
	
	public static function getImagesFromDir($dir){
		$images = glob($dir . "{*.jpg,*.jpeg}", GLOB_BRACE);
		$listImages = array();
		foreach($images as $image){
			$listImages[] = str_replace($dir, '', $image);
		}
		return $listImages;
	}
	
	public static function getImageHeight($file){
		if(is_file($file)){
			$size = getimagesize($file);
			if(isset($size[1])){
				return $size[1];
			}
		}
		return 0;
	}


}
