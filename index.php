<?php

require __DIR__ . "/inc/bootstrap.php";
require PROJECT_ROOT_PATH . "/Api/UserController.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$objFeedController = new UserController();
if($uri[2] = 'consulta' && $uri[3] = 'final-placa')
{
    $strMethodName = 'finalPlaca';
}else{
$strMethodName = $uri[2];
}
$objFeedController->{$strMethodName}();

?>
 
