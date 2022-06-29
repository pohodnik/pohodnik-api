<?php
    require_once("err.php");
    require_once("config.php");
    
    require_once(__DIR__."../vendor/autoload.php");

    $CLOUDINARY_URL = getConf('CLOUDINARY_URL');

    function isUrlCloudinary($url) {
        $pos = strrpos($url, "cloudinary");
        return !($pos === false);
    }

    function getCloudinaryPublickIdByUrl($url) {
        preg_match("/upload\/(?:v\d+\/)?([^\.]+)/", $url, $matches);
        $public_id = $matches[1];
        
        return $public_id;
    }
    

    function deleteCloudImageByUrl($url) {
        global $CLOUDINARY_URL;
        (new Cloudinary\Api\Upload\UploadApi($CLOUDINARY_URL))->destroy(getCloudinaryPublickIdByUrl($url));
    }
    

    function uploadCloudImage($newFilePath, $folder, $needSizes) {
        global $CLOUDINARY_URL;
        $res = (new Cloudinary\Api\Upload\UploadApi($CLOUDINARY_URL))->upload(
            $newFilePath,
            [ 
                "folder" => $folder,
                "eager" => array_values($needSizes)
            ]
        );

        return $res;
    }
  