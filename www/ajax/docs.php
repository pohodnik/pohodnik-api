<?php
require("../vendor/autoload.php");
$openapi = \OpenApi\scan(__DIR__, array('exclude' => 'lib'));
echo $openapi->toJson();
 
/**
 * @OA\Info(title="Pohodnik API", version="0.1")
 */