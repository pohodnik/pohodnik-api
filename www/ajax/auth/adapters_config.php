<?php
    require_once("../../blocks/config.php");

    $adapterConfigs = array();

    if (!empty(getConf('VK_CLIENT_ID')) && !empty(getConf('VK_CLIENT_SECRET'))) {
        $adapterConfigs['vk'] = array(
            'client_id'     => getConf('VK_CLIENT_ID'),
            'client_secret' => getConf('VK_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=vk',
            'name'=>'ВКонтакте'
        );
    }


    if (!empty(getConf('YANDEX_CLIENT_ID')) && !empty(getConf('YANDEX_CLIENT_SECRET'))) {
        $adapterConfigs['yandex'] = array(
            'client_id'     => getConf('YANDEX_CLIENT_ID'),
            'client_secret' => getConf('YANDEX_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=yandex',
            'name'=>'Яндекс'
        );
    }

    if (!empty(getConf('GOOGLE_CLIENT_ID')) && !empty(getConf('GOOGLE_CLIENT_SECRET'))) {
        $adapterConfigs['google'] = array(
            'client_id'     => getConf('GOOGLE_CLIENT_ID'),
            'client_secret' => getConf('GOOGLE_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=google',
            'name'=>'Google'
        );
    }


    if (!empty(getConf('TG_CLIENT_ID')) && !empty(getConf('TG_CLIENT_SECRET'))) {
        $adapterConfigs['telegram'] = array(
            'client_id'     => getConf('TG_CLIENT_ID'),
            'client_secret' => getConf('TG_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=telegram',
            'name'=>'Телеграм'
        );
    }

    if (!empty(getConf('STRAVA_CLIENT_ID')) && !empty(getConf('STRAVA_CLIENT_SECRET'))) {
        $adapterConfigs['strava'] = array(
            'client_id'     => getConf('STRAVA_CLIENT_ID'),
            'client_secret' => getConf('STRAVA_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=strava',
            'name'=>'Strava'
        );
    }


    if (!empty(getConf('FACEBOOK_CLIENT_ID')) && !empty(getConf('FACEBOOK_CLIENT_SECRET'))) {
        $adapterConfigs['facebook'] = array(
            'client_id'     => getConf('FACEBOOK_CLIENT_ID'),
            'client_secret' => getConf('FACEBOOK_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=facebook',
            'name'=>'facebook'
        );
    }


    if (!empty(getConf('OK_CLIENT_ID')) && !empty(getConf('OK_CLIENT_SECRET')) && !empty(getConf('OK_PUBLIC_KEY'))) {
        $adapterConfigs['odnoklassniki'] = array(
            'client_id'     => getConf('OK_CLIENT_ID'),
            'client_secret' => getConf('OK_CLIENT_SECRET'),
            'public_key' => getConf('OK_PUBLIC_KEY'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=odnoklassniki',
            'name'=>'Одноклассники'
        );
    }


    if (!empty(getConf('MAILRU_CLIENT_ID')) && !empty(getConf('MAILRU_CLIENT_SECRET'))) {
        $adapterConfigs['mailru'] = array(
            'client_id'     => getConf('MAILRU_CLIENT_ID'),
            'client_secret' => getConf('MAILRU_CLIENT_SECRET'),
            'public_key' => getConf('OK_PUBLIC_KEY'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=mailru',
            'name'=>'Mail.Ru'
        );
    }

