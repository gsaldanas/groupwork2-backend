<?php

require_once "includes/Db.class.php";
require_once "includes/Todos.class.php";

$db = new Db();
$todos = new Todos($db);

$res = $todos->getAll();

print_r($res);
