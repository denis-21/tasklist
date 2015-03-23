<?php
session_start();
include_once('config.php');


$info = explode('/', $_GET['q']);
$params = array();

foreach ($info as $v) {
    if ($v != '')
        $params[] = $v;
}

$action = 'action_';
$action .= (isset($params[1])) ? $params[1] : 'index';

switch ($params[0]) {
    case 'task':
        $controller = new C_Task();
        break;
    default:
        $controller = new C_Task();
}

$controller->Request($action, $params);
?>
