<?php
require_once "includes/TodoLists.class.php";

$args = $_REQUEST;
$endpoint = $args['endpoint'];
$endpoints = ["lists", "list"];
if (!in_array($endpoint, $endpoints)) {
    return;
}
// TODO: documentation

switch ($endpoint) {
    case 'lists':
        // Ensure that the request method is GET
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $response->status = 'error';
            $response->message = 'Invalid request method';
            return;
        }
        $response->status = 'success';
        $response->test = 'lists';
        $db = new Db();
        $lists = new TodoLists($db);
        $response->lists = $lists->getAll();
        break;

    case 'list':
        // Ensure that the 'id' parameter is set and is a positive integer
        if (!isset($args['id']) || !ctype_digit($args['id']) || $args['id'] <= 0) {
            $response->status = 'error';
            $response->message = 'Invalid ID parameter';
            return;
        }

        $db = new Db();
        $lists = new TodoLists($db);
        $list = $lists->getById($args['id']);

        // Check if the list exists
        if (!$list) {
            $response->status = 'error';
            $response->message = 'List not found';
            return;
        }

        $response->status = 'success';
        $response->test = 'list';
        $response->lists = $list;
        break;

    default:
        break;
}
