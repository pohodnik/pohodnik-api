<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    require_once __DIR__.'/../lib/SocialAuther/autoload.php';
    include __DIR__.'/adapters_config.php';
    include __DIR__.'/../../blocks/global.php';
    $adapters = array();


    $res = array();
    foreach ($adapterConfigs as $adapter => $settings) {
        $class = 'SocialAuther\Adapter\\' . ucfirst($adapter);
        $adapters[$adapter] = new $class($settings);
        $res[] = array(
            "id" => $adapter,
            "url" => $adapters[$adapter]->getAuthUrl(),
            "name" => $adapters[$adapter]->getFullName()
        );
    }

    die(out($res));
?>
