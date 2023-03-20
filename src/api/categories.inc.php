<?php
require_once "includes/Categories.class.php";

$args = $_REQUEST;
$endpoints = ["categories", "category"];

// TODO: documentation

if (!in_array($args['endpoint'], $endpoints)) {
    return;
}

switch ($endpoint) {
    case 'categories':
        // TODO: validation :O
        $db = new Db();
        $categories = new Categories($db);

        $response->status = 'success';
        $response->categories = $categories->getAll();
        break;
    case 'category':
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                // TODO: validation ;)
                $db = new Db();
                $categories = new Categories($db);

                $response->categories = $categories->getById($args['id']);
                $response->status = 'success';
                break;
            case 'POST':
                // TODO: validation :D
                $db = new Db();
                $categories = new Categories($db);

                // get POST data in JSON format
                $params = jsonDecodeInput();
                $categories->add($params);

                $response->status = 'success';
                $response->message = 'Category ' . $params['title'] . " has been added";
                break;
            default:
                // TODO: validation :P
        }
        break;
    default:
        break;
}
