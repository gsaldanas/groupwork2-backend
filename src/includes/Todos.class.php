<?php

class Todos
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll($offset = 0, $limit = 50, $filters = [])
    {
        $sql = "SELECT * FROM todos LIMIT $limit OFFSET $offset";
        return $this->db->executeQuery($sql, $filters);
    }
}
