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
    public function update($id, $data)
    {
        //  TODO: even more validation!!
        $updateColumns = $data;
        array_walk($updateColumns, function (&$value, $key) {
            $value = "$key = '$value'";
        });
        $updateColumns = join(', ', array_values($updateColumns));
        $sql = "UPDATE todos SET $updateColumns, updated_at = NOW() WHERE id = $id";
        $this->db->executeQuery($sql);
    }
    public function delete($id)
    {
        //  TODO: even more validation!!!
        $sql = "UPDATE todos SET is_visible = 0, updated_at = NOW() WHERE id = $id";
        $this->db->executeQuery($sql);
    }
}
