<?php
require_once "includes/Categories.class.php";

$args = $_REQUEST;
$endpoints = ["categories", "category"];
if (!in_array($args['endpoint'], $endpoints)) {
    return;
}

// your switch here

print '<h1>categories.inc.php file :) </h1><br /><pre>';
print_r($args);
print '</pre>';
