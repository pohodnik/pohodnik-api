<?php
require("../vendor/autoload.php");
$openapi = \OpenApi\scan(__DIR__, array('pattern' => 'doc.php', 'exclude' => array('lib')));
echo $openapi->toJson();
 
/**
 * @OA\Info(title="Pohodnik API", version="0.1")
 */