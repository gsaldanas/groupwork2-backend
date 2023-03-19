<?php

function jsonDecodeInput()
{
    $params = file_get_contents('php://input');
    return json_decode($params, true);
}
