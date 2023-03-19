<?php

class Todos
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM todos";
        return $this->db->executeQuery($sql);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM todos WHERE id=:id";
        return $this->db->executeQuery($sql, ['id' => $id]);
    }
    public function add($data)
    {
        //  TODO: even more validation!
        $keys = join(", ", array_keys($data));
        $values =  '"' . join('", "', array_values($data)) . '"';
        $sql = "INSERT INTO todos ($keys) VALUES ($values)";
        $this->db->executeQuery($sql);
    }
}
