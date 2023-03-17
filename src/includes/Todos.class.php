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
        $keys = array_keys($data);
        $values = array_values($data);
        print_r($keys);
        print_r($values);
        print_r($data);
        // $sql = "SELECT * FROM todos WHERE id=:id";
        // return $this->db->executeQuery($sql, $data);
    }
}
