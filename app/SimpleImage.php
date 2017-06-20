<?php

namespace App;

/**
 * Class SimpleImage
 * @package App
 */
class SimpleImage
{
    public static $model = null;

    /**
     * @var array
     */
    private static $images = [];

    /**
     * @var array
     */
    private static $delImages = [];

    /**
     * @param null $model
     */
    public static function setModel($model)
    {
        self::$model = $model;
    }

    /**
     * @param array $images
     */
    public static function setImages(array $images)
    {
        self::$images = $images;
    }

    /**
     * @param array $images
     */
    public static function setDelImages(array $images)
    {
        self::$delImages = $images;
    }

    /**
     * @param $image
     * @param string $prefix
     * @return string
     */
    public static function getImagePath($image, $prefix = 'thumbnail')
    {
        $arr = explode('/', $image);
        $arrKeys = array_keys($arr);
        $arrLastElementKey = end($arrKeys);
        $image = $prefix . '-' . $arr[$arrLastElementKey];
        $arr[$arrLastElementKey] = $image;
        $image = implode('/', $arr);
        return $image;
    }

    /**
     * Get image by path
     * @param $image
     */
    public static function image($image, $thumb = false, $prefix = 'thumbnail', $no_image = true)
    {
        if (is_file($image)) {
            if ($thumb) {
                $image_thumbnail = self::getImagePath($image, $prefix);
                $image = is_file($image_thumbnail) ? $image_thumbnail : $image;
            }
            return asset($image);
        }
        return $no_image ? asset('images/no_image.png') : '';
    }

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
            if (!$checkImageSizes || ($checkImageSizes && ($imgWidth >= $width || $imgHeight >= $height))) {
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
      try {
          self::resizeImage($big_width, $big_height, $path, $path);
          self::resizeImage($thumb_width, $thumb_height, $path, $path_thumbnail);
          if (!empty(self::$images)) {
              foreach (self::$images as $image) {
                  self::resizeImage($image['width'], $image['height'], $path, $image['path']);
              }
          }
      } catch (\Exception $e) {
          dd($e);
      }
    }

    /**
     * @param array $images
     */
    public static function deleteImages(array $images = [])
    {
        if (!empty($images)) {
            foreach ($images as $image) {
                $image = $_SERVER['DOCUMENT_ROOT'] . '/' . $image;
                if (is_file($image)) {
                    unlink($image);
                }
                if (is_file(($thumbnailImage = self::getImagePath($image, 'thumbnail')))) {
                    unlink($thumbnailImage);
                }
                if (is_file(($slideImage = self::getImagePath($image, 'slide')))) {
                    unlink($slideImage);
                }
            }
        }
    }

}
