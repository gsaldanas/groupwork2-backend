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
    public function add($data)
    {
        $keys = array_keys($data);
        $cols = implode(', ', $keys);


        $values = array_map(function ($key) {
            return ':' . $key;
        }, $keys);
        $values = implode(', ', $values);

        // print_r($cols);
        // print_r($values);
        // print_r($data);
        $sql = "INSERT INTO todo_lists($cols) VALUES ($values)";
        return $this->db->executeQuery($sql, $data);
    }
    public function delete($id)
    {
        //  TODO: even more validation!!!
        $sql = "UPDATE todo_lists SET is_visible = 0, updated_at = NOW() WHERE id = $id";
        $this->db->executeQuery($sql);
    }
}
