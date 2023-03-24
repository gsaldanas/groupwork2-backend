<?php
require_once "includes/Todos.class.php";
require_once "includes/helpers.inc.php";

$args = $_REQUEST;
$endpoint = $args['endpoint'];
$allowedEndpoints = ["todos", "todo"];

// TODO: documentation

if (!in_array($endpoint, $allowedEndpoints)) {
    http_response_code(400);
    return;
}

switch ($endpoint) {
    case 'todos':
        // Ensure that the request method is GET
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(400);
            $response->status = 'error';
            $response->message = 'Invalid request method';
            return;
        }

        $db = new Db();
        $todos = new Todos($db);

        // init filter
        $filter = ['is_visible' => 1];

        // add filter list id to init filter (if exists)
        if (isset($args['id'])) {
            $filter = array_merge($filter, ['todo_lists_id' => $args['id']]);
        }

        $response->todos = $todos->getAll($filter);
        $response->status = 'success';
        break;
    case 'todo':
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                // Ensure that the 'id' parameter is set and is a positive integer
                if (!isset($args['id']) || !ctype_digit($args['id']) || $args['id'] <= 0) {
                    $response->status = 'error';
                    $response->message = 'Invalid ID parameter';
                    http_response_code(404);
                    return;
                }

                $db = new Db();
                $todos = new Todos($db);
                $todo = $todos->getById($args['id']);

                // Check if the list exists
                if (!$todo) {
                    $response->status = 'error';
                    $response->message = 'Todo not found';
                    http_response_code(404);
                    return;
                }

                $response->status = 'success';
                $response->todos = $todo;
                break;
            case 'POST':
                $db = new Db();
                $todos = new Todos($db);

                // get POST data in JSON format
                $params = jsonDecodeInput();

                try {
                    $todos->add($params);
                    $response->status = 'success';
                    $response->message = "Todo added";
                } catch (\Throwable $th) {
                    http_response_code(400);
                    $response->status = 'error';
                    $response->message = $th->getMessage();
                }
                break;
            case 'PATCH':
                $db = new Db();
                $todos = new Todos($db);

                // get PATCH data in JSON format
                $params = jsonDecodeInput();
                try {
                    $todos->update($args['id'], $params);

                    $response->status = 'success';
                    $response->message = "Todo updated";
                } catch (\Throwable $th) {
                    http_response_code(400);
                    $response->status = 'error';
                    $response->message = $th->getMessage();
                }
                break;
                break;
            case 'DELETE':
                // Ensure that the 'id' parameter is set and is a positive integer
                if (!isset($args['id']) || !ctype_digit($args['id']) || $args['id'] <= 0) {
                    $response->status = 'error';
                    $response->message = 'Invalid ID parameter';
                    http_response_code(404);
                    return;
                }

                $db = new Db();
                $todos = new Todos($db);

                try {
                    $todos->delete($args['id']);
                    $response->status = 'success';
                    $response->message = $args['id'] . " has been deleted";
                } catch (\Throwable $th) {
                    http_response_code(400);
                    $response->status = 'error';
                    $response->message = $th->getMessage();
                }
                break;
            default:
                http_response_code(400);
                $response->status = 'error';
                $response->message = 'Invalid request method';
                return;
        }
        break;
    default:
        break;
}
