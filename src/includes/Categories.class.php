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
    public function add($data)
    {
        //  TODO: even more validation!
        $keys = join(", ", array_keys($data));
        $values =  '"' . join('", "', array_values($data)) . '"';
        $sql = "INSERT INTO categories ($keys) VALUES ($values)";
        $this->db->executeQuery($sql);
    }
}
