<?php

class Categories
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM categories";
        return $this->db->executeQuery($sql);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM categories WHERE id=:id";
        return $this->db->executeQuery($sql, ['id' => $id]);
    }
}
