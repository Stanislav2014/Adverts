<?php

namespace App\Helpers\Advert;

class Advert
{
    public static function isSerialized($data)
    {
        // if it isn't a string, it isn't serialized
        if ( !is_string( $data ) )
            return false;
        $data = trim( $data );
        if ( 'N;' == $data )
            return true;
        if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
            return false;
        switch ( $badions[1] ) {
            case 'a' :
            case 'O' :
            case 's' :
                if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                    return true;
                break;
        }
        return false;
    }
    public static function getMimeType($path)
    {
        $result = false;

        if (is_file($path) === true)
        {
            if (function_exists('finfo_open') === true)
            {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);

                if (is_resource($finfo) === true)
                {
                    $result = finfo_file($finfo, $path);
                }

                finfo_close($finfo);
            }

            else if (function_exists('mime_content_type') === true)
            {
                $result = preg_replace('~^(.+);.*$~', '$1', mime_content_type($path));
            }

            else if (function_exists('exif_imagetype') === true)
            {
                $result = image_type_to_mime_type(exif_imagetype($path));
            }
        }

        return $result;
    }
}
