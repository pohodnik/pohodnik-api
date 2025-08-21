<?php

header('Content-type: application/json');
    require_once '../../blocks/rules.php';
    require_once '../../blocks/global.php';

    $id_hiking = intval($_GET['id_hiking']);
    $id_user = isset($_GET['id_user']) ? intval($_GET['id_user']) : null;

    die(jout(getRulesForHiking($id_hiking, $id_user)));
