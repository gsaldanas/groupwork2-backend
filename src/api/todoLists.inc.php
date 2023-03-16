<?php
require_once "includes/TodoLists.class.php";

$args = $_REQUEST;
$endpoints = ["lists", "list"];
if (!in_array($args['endpoint'], $endpoints)) {
    return;
}

// your switch here

print '<h1>todoLists.inc.php file :) </h1><br /><pre>';
print_r($args);
print '</pre>';
