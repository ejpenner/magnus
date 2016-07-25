<?php

namespace Magnus\Helpers;

use Magnus\User;
use Magnus\Opus;
use Intervention\Image\Facades\Image;

class Images {
    const resizeTo = 250;
    const resizeExtension = 'jpg';

    /**
     * Handle the uploaded file, rename the file, move the file, return the filepath as a string
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public static function storeImage(User $user, Opus $opus, &$request)
    {
        $originalFileName = $request->file('image')->getClientOriginalName();
        $fileName = $user->slug.'-'.date('Ymd') . substr(microtime(), 2, 8).'-'.$originalFileName; // renaming image
        $request->file('image')->move($opus->directory, $fileName); // uploading file to given path
        $fullPath = $opus->directory."/".$fileName; // set the image field to the full path
        return $fullPath;
    }

    /**
     * Handle the uploaded file for the opus' preview image
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public static function storePreview(User $user, Opus $opus, &$request)
    {
        $previewSize = $request->has('resizeTo') ? $request->input('resizeTo') : $opus->defaultResize;
        $fileName = $user->slug.'-'.date('Ymd') .'-'. substr(microtime(), 2, 8).'-p.'. self::resizeExtension; // renaming image
        $thumbnail = self::resize($opus->getFilePath(), $previewSize);
        $fullPath = $opus->directory."/".$fileName;
        $thumbnail->save($fullPath);
        return $fullPath;
    }

    /**
     *  Using the uploaded file, create a thumbnail and save it into the thumbnail folder
     * @param User $user
     * @param $request
     * @return string
     */
    public static function storeThumbnail(User $user, Opus $opus)
    {
        $fileName = $user->slug.'-'.date('Ymd') .'-'. substr(microtime(), 12, 8).'-t.'. self::resizeExtension; // renaming image
        $thumbnail = self::resize($opus->getFilePath());
        $fullPath = $opus->directory."/".$fileName;
        $thumbnail->save($fullPath);
        return $fullPath;
    }

    /**
     * Resize the opus' image for it's thumbnail or preview
     * @param $image
     * @return Image
     */
    private static function resize($image, $size = null)
    {
        $resize = Image::make($image);
        $newRes = isset($size) ? $size : self::resizeTo;
        $ratio = $resize->width() / $resize->height();

        if ($ratio > 1) { // image is wider than tall
            $resize->resize($newRes, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else { // image is taller than wide
            $resize->resize(null, $newRes, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        return $resize;
    }
}