<?php

require "includes/Db.class.php";
require "includes/Todos.class.php";

$db = new Db();
$todos = new Todos($db);

$res = $todos->getAll();

print_r($res);
