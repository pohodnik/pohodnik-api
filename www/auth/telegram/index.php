<?php
    define('BOT_USERNAME', getenv('TG_CLIENT_ID')); // place username of your bot here

function getTelegramUserData() {
  if (isset($_COOKIE['tg_user'])) {
    $auth_data_json = urldecode($_COOKIE['tg_user']);
    $auth_data = json_decode($auth_data_json, true);
    return $auth_data;
  }
  return false;
}

if ($_GET['logout']) {
  setcookie('tg_user', '');
  header('Location: login_example.php');
}

$tg_user = getTelegramUserData();
if ($tg_user !== false) {
  $first_name = htmlspecialchars($tg_user['first_name']);
  $last_name = htmlspecialchars($tg_user['last_name']);
  if (isset($tg_user['username'])) {
    $username = htmlspecialchars($tg_user['username']);
    $html = "<h1>Hello, <a href=\"https://t.me/{$username}\">{$first_name} {$last_name}</a>!</h1>";
  } else {
    $html = "<h1>Hello, {$first_name} {$last_name}!</h1>";
  }
  if (isset($tg_user['photo_url'])) {
    $photo_url = htmlspecialchars($tg_user['photo_url']);
    $html .= "<img src=\"{$photo_url}\">";
  }
  $html .= "<p><a href=\"?logout=1\">Log out</a></p>";
} else {
  $bot_username = BOT_USERNAME;
  $html = <<<HTML
<h1>Привет, походник!</h1>
<script async src="https://telegram.org/js/telegram-widget.js?2" data-telegram-login="{$bot_username}" data-size="large" data-radius="4" data-auth-url="https://pohodnik.tk/auth/?provider=telegram" data-request-access="write"></script>
HTML;
}


  echo <<<HTML
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Авторизация походника через телеграм</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
<style>
  h1 {
  font-family: "Russo One", sans-serif;
  font-weight: 400;
  font-style: normal;
}  
</style>
  </head>
  <body><center>{$html}</center></body>
</html>
HTML;

?>