<?php
require_once "includes/Todos.class.php";

$args = $_REQUEST;
$endpoint = $args['endpoint'];
$endpoints = ["todos", "todo"];

// TODO: documentation

if (!in_array($endpoint, $endpoints)) {
    return;
}

switch ($endpoint) {
    case 'todos':
        $response->status = 'success';
        $response->test = 'todos';
        $db = new Db();
        $todos = new Todos($db);
        $response->todos = $todos->getAll();
        break;
    case 'todo':
        // TODO: validation ;)
        $response->status = 'success';
        $response->test = 'todo';
        $db = new Db();
        $todos = new Todos($db);
        $response->todos = $todos->getById($args['id']);
        break;
    default:
        break;
}
