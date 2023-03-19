<?php
require_once "includes/Todos.class.php";

$args = $_REQUEST;
$endpoint = $args['endpoint'];
$allowedEndpoints = ["todos", "todo"];

// TODO: documentation

if (!in_array($endpoint, $allowedEndpoints)) {
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
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                // TODO: validation :D
                $db = new Db();
                $todos = new Todos($db);

                // TODO: add api call to get list name
                $listName = $_POST['todo_lists_id'];
                $response->status = 'success';
                $response->message = $_POST['title'] . " has been added to " . $listName;
                break;
            default:
                // TODO: validation ;)
                $response->status = 'success';
                $db = new Db();
                $todos = new Todos($db);
                $response->todos = $todos->getById($args['id']);
                break;
        }
        break;
    default:
        break;
}
