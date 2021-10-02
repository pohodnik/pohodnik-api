<?php
if (!isset($_COOKIE["user"])){exit(json_encode(array("error"=>"Пожалуйста, авторизуйтесь. \r\n")));}
ini_set('memory_limit', '-1');
?>
