<?php
require_once "includes/Todos.class.php";

$args = $_REQUEST;
$endpoints = ["todos", "todo"];
if (!in_array($args['endpoint'], $endpoints)) {
    return;
}

// your switch here

print '<h1>todos.inc.php file :) </h1><br /><pre>';
print_r($args);
print '</pre>';
