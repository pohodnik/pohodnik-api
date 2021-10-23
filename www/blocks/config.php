<?php
function getConf($key) {
    $config = array(
        'MYSQL_HOST' => getenv('MYSQL_HOST'),
        'MYSQL_USER' => getenv('MYSQL_USER'),
        'MYSQL_PASSWORD' => getenv('MYSQL_PASSWORD'),
        'MYSQL_DATABASE' => getenv('MYSQL_DATABASE'),
        'MIGRATOR_USER' => getenv('MIGRATOR_USER'),
        'MIGRATOR_PASSWORD' => getenv('MIGRATOR_PASSWORD')
    );
    return $config[$key];
}