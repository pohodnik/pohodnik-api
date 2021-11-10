<?php
    require_once('./blocks/imagesStorage.php');
    require_once('./blocks/err.php');
    include("./vendor/autoload.php");

    $url = 'https://res.cloudinary.com/djnreh3xq/image/upload/v1635541851/images/avatars/1/djphajpkd5vgphawlk61.png';

    echo '<p>isUrlCloudinary: '.isUrlCloudinary($url).';</p>';
    $res = getCloudinaryPublickIdByUrl($url);
   
    echo '<p>public_id: <pre>';
    print_r($res);
    echo '</pre></p>';
