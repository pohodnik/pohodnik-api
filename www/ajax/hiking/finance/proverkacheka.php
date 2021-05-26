<?php
//параметры из формы запроса полученные от браузера клиента
$tPar=[
    'fn' => $_POST['fn'],    //ФН
    'fd' => $_POST['fd'],    //ФД
    'fp' => $_POST['fp'],    //ФП
    't' => $_POST['t'],      //время с чека
    'n' => $_POST['n'],      //вид кассового чека
    's' => $_POST['s'],      //сумма чека
    'qr' => $_POST['qr'],    //признак сканирования QR-кода
    'token' => '2177.Kuwq6fabMknLg1Sds' //здесь прописываем токен доступа
  ];

  //выполняем запрос на сервер Проверка чека используя API
  $tСurl = curl_init();
  curl_setopt($tСurl, CURLOPT_URL, 'https://proverkacheka.com/api/v1/check/get');
  curl_setopt($tСurl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($tСurl, CURLOPT_POST, true);
  curl_setopt($tСurl, CURLOPT_POSTFIELDS, $tPar);
  $tRes = curl_exec($tСurl);
  curl_close($tСurl);

  //обрабатываем результат запроса для сохранения в БД
  $tCheck=json_decode($tRes,true);
  if (isset($tCheck['code']) && $tCheck['code']==1) {
    // Чек получен
    //например, сумма чека: $tCheck['data']['json']['totalSum']
    die($tRes);
  } else {
    die(json_encode(array('error' => $tCheck)));
  }