<?php
require_once "includes/TodoLists.class.php";
require_once "includes/helpers.inc.php";


$args = $_REQUEST;
$endpoint = $args['endpoint'];
$endpoints = ["lists", "list"];
if (!in_array($endpoint, $endpoints)) {
    http_response_code(400);
    return;
}


switch ($endpoint) {
    case 'lists':
        // Ensure that the request method is GET
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(400);
            $response->status = 'error';
            $response->message = 'Invalid request method';
            return;
        }
        $db = new Db();
        $lists = new TodoLists($db);
        $response->lists = $lists->getAll();
        $response->status = 'success';
        break;

    case 'list':
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
                $lists = new TodoLists($db);
                $list = $lists->getById($args['id']);

                // Check if the list exists
                if (!$list) {
                    $response->status = 'error';
                    $response->message = 'List not found';
                    http_response_code(404);
                    return;
                }

                $response->status = 'success';
                $response->lists = $list;
                break;
            case 'POST':
                $db = new Db();
                $lists = new TodoLists($db);

                // get POST data in JSON format
                $params = jsonDecodeInput();

                try {
                    $lists->add($params);
                    $response->status = 'success';
                    $response->message = 'List added';
                } catch (\Throwable $th) {
                    http_response_code(400);
                    $response->status = 'error';
                    $response->message = $th->getMessage();
                }
                break;
            case 'PATCH':
                $db = new Db();
                $lists = new TodoLists($db);

                // get PATCH data in JSON format
                $params = jsonDecodeInput();
                try {
                    $lists->update($args['id'], $params);
                    $response->status = 'success';
                    $response->message = "List updated";
                } catch (\Throwable $th) {
                    http_response_code(400);
                    $response->status = 'error';
                    $response->message = $th->getMessage();
                }
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
                $lists = new TodoLists($db);

                try {
                    $lists->delete($args['id']);
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

    default:

        break;
}
