<?php

class TodoLists
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll($offset = 0, $limit = 50, $filters = [])
    {
        $sql = "SELECT * FROM todo_lists LIMIT $limit OFFSET $offset";
        return $this->db->executeQuery($sql, $filters);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM todo_lists WHERE id=:id";
        return $this->db->executeQuery($sql, ['id' => $id]);
    }
}
