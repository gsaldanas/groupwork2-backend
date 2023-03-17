<?php
require_once "includes/Db.class.php";

$response = new StdClass;

require_once "api/todoLists.inc.php";
require_once "api/todos.inc.php";
require_once "api/categories.inc.php";



header('Content-Type: application/json; charset=utf-8');
print json_encode($response);
exit;
