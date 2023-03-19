<?php
require_once "includes/Todos.class.php";
require_once "includes/helpers.inc.php";

$args = $_REQUEST;
$endpoint = $args['endpoint'];
$allowedEndpoints = ["todos", "todo"];

// TODO: documentation

if (!in_array($endpoint, $allowedEndpoints)) {
    return;
}

switch ($endpoint) {
    case 'todos':
        // TODO: validation :O
        $response->status = 'success';
        $response->test = 'todos';
        $db = new Db();
        $todos = new Todos($db);
        $response->todos = $todos->getAll();
        break;
    case 'todo':
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                // TODO: validation ;)
                $db = new Db();
                $todos = new Todos($db);
                $response->todos = $todos->getById($args['id']);
                $response->status = 'success';
                break;
            case 'POST':
                // TODO: validation :D
                $db = new Db();
                $todos = new Todos($db);

                // get POST data in JSON format
                $params = jsonDecodeInput();
                $todos->add($params);

                // TODO: add api call to get list name
                $listName = $params['todo_lists_id'];

                $response->status = 'success';
                $response->message = $params['title'] . " has been added to " . $listName;
                break;
            case 'PATCH':
                // TODO: validation :)
                $db = new Db();
                $todos = new Todos($db);

                // get PATCH data in JSON format
                $params = jsonDecodeInput();
                $todos->update($args['id'], $params);

                $response->status = 'success';
                $response->message = $params['title'] . " has been added updated";
                break;
            default:
                // TODO: validation :P
        }
        break;
    default:
        break;
}
