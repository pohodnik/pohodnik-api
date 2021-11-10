<?php
    require_once("err.php");

    function isUrlCloudinary($url) {
        $pos = strrpos($url, "cloudinary");
        return !($pos === false);
    }

    function getCloudinaryPublickIdByUrl($url) {
        global $cloudinaryApi;
        preg_match("/upload\/(?:v\d+\/)?([^\.]+)/", $url, $matches);
        $public_id = $matches[1];
        
        return $public_id; //$cloudinaryApi->destroy($public_id);
    }
    

  