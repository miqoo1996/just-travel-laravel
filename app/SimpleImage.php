<?php

namespace App;

/**
 * Class SimpleImage
 * @package App
 */
class SimpleImage
{
    /**
     * Resize image php @link Imagick
     * @param $width
     * @param $height
     * @param $path
     * @param null $path_thumbnail
     * @param bool $crop
     * @param bool $checkImageSizes
     * @return bool
     */
    public static function resizeImage($width, $height, $path, $path_thumbnail = null, $crop = true, $checkImageSizes = false)
    {
        if (!$path_thumbnail)
            $path_thumbnail = $path;
        if (is_file($path)) {
            $thumb = new \Imagick($path);
            $imageprops = $thumb->getImageGeometry();
            $imgWidth = $imageprops['width'];
            $imgHeight = $imageprops['height'];
            if (!$checkImageSizes || ($checkImageSizes && $imgWidth > $width && $imgHeight > $height)) {
                if ($crop) {
                    $thumb->cropThumbnailImage($width, $height);
                } else {
                    $thumb->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, 1, true);
                }
            }
            $thumb->writeImage($path_thumbnail);
            $thumb->destroy();
            return true;
        }
        return false;
    }

    /**
     * Resize and crop images
     * @param $path
     * @param $path_thumbnail
     * @param $big_width
     * @param $big_height
     * @param $thumb_width
     * @param $thumb_height
     */
    public static function resize($path, $path_thumbnail, $big_width, $big_height, $thumb_width, $thumb_height)
    {
        self::resizeImage($big_width, $big_height, $path, $path);
        self::resizeImage($thumb_width, $thumb_height, $path, $path_thumbnail);
    }

}
