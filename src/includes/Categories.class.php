<?php

class Categories
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll($offset = 0, $limit = 50, $filters = [])
    {
        $sql = "SELECT * FROM categories LIMIT $limit OFFSET $offset";
        return $this->db->executeQuery($sql, $filters);
    }
}
