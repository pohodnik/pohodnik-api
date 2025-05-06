<?php
    $adapterConfigs = array();

    if (!empty(getenv('VK_CLIENT_ID')) && !empty(getenv('VK_CLIENT_SECRET'))) {
        $adapterConfigs['vk'] = array(
            'client_id'     => getenv('VK_CLIENT_ID'),
            'client_secret' => getenv('VK_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=vk',
            'name'=>'ВКонтакте'
        );
    }


    if (!empty(getenv('YANDEX_CLIENT_ID')) && !empty(getenv('YANDEX_CLIENT_SECRET'))) {
        $adapterConfigs['yandex'] = array(
            'client_id'     => getenv('YANDEX_CLIENT_ID'),
            'client_secret' => getenv('YANDEX_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=yandex',
            'name'=>'Яндекс'
        );
    }

    if (!empty(getenv('GOOGLE_CLIENT_ID')) && !empty(getenv('GOOGLE_CLIENT_SECRET'))) {
        $adapterConfigs['google'] = array(
            'client_id'     => getenv('GOOGLE_CLIENT_ID'),
            'client_secret' => getenv('GOOGLE_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=google',
            'name'=>'Google'
        );
    }


    if (!empty(getenv('TG_CLIENT_ID')) && !empty(getenv('TG_CLIENT_SECRET'))) {
        $adapterConfigs['telegram'] = array(
            'client_id'     => getenv('TG_CLIENT_ID'),
            'client_secret' => getenv('TG_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=telegram',
            'name'=>'Телеграм'
        );
    }

    if (!empty(getenv('STRAVA_CLIENT_ID')) && !empty(getenv('STRAVA_CLIENT_SECRET'))) {
        $adapterConfigs['strava'] = array(
            'client_id'     => getenv('STRAVA_CLIENT_ID'),
            'client_secret' => getenv('STRAVA_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=strava',
            'name'=>'Strava'
        );
    }


    if (!empty(getenv('FACEBOOK_CLIENT_ID')) && !empty(getenv('FACEBOOK_CLIENT_SECRET'))) {
        $adapterConfigs['facebook'] = array(
            'client_id'     => getenv('FACEBOOK_CLIENT_ID'),
            'client_secret' => getenv('FACEBOOK_CLIENT_SECRET'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=facebook',
            'name'=>'facebook'
        );
    }


    if (!empty(getenv('OK_CLIENT_ID')) && !empty(getenv('OK_CLIENT_SECRET')) && !empty(getenv('OK_PUBLIC_KEY'))) {
        $adapterConfigs['odnoklassniki'] = array(
            'client_id'     => getenv('OK_CLIENT_ID'),
            'client_secret' => getenv('OK_CLIENT_SECRET'),
            'public_key' => getenv('OK_PUBLIC_KEY'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=odnoklassniki',
            'name'=>'Одноклассники'
        );
    }


    if (!empty(getenv('MAILRU_CLIENT_ID')) && !empty(getenv('MAILRU_CLIENT_SECRET'))) {
        $adapterConfigs['mailru'] = array(
            'client_id'     => getenv('MAILRU_CLIENT_ID'),
            'client_secret' => getenv('MAILRU_CLIENT_SECRET'),
            'public_key' => getenv('OK_PUBLIC_KEY'),
            'redirect_uri'  => 'https://pohodnik.tk/auth/?provider=mailru',
            'name'=>'Mail.Ru'
        );
    }

