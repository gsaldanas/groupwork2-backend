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
        // Check if all required fields are present in the data
        $requiredFields = ['title'];
        if (array_diff($requiredFields, array_keys($data))) {
            throw new Exception('Missing required fields');
        }

        // Check that all fields in $data are allowed
        $allowedFields = ['title'];
        if (array_diff(array_keys($data), $allowedFields)) {
            throw new Exception('Invalid fields in data');
        }

        $keys = array_keys($data);
        $cols = implode(', ', $keys);

        $values = array_map(function ($key) {
            return ':' . $key;
        }, $keys);
        $values = implode(', ', $values);
        $sql = "INSERT INTO todo_lists($cols) VALUES ($values)";
        return $this->db->executeQuery($sql, $data);
    }


    public function update($id, $data)
    {
        // Ensure id is a valid integer
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException('Invalid id');
        }

        // Check that all fields in $data are allowed
        $allowedFields = ['title'];
        if (array_diff(array_keys($data), $allowedFields)) {
            throw new Exception('Invalid fields in data');
        }

        $updateColumns = $data;
        array_walk($updateColumns, function (&$value, $key) {
            $value = "$key = '$value'";
        });
        $updateColumns = join(', ', array_values($updateColumns));
        $sql = "UPDATE todo_lists SET $updateColumns, updated_at = NOW() WHERE id = $id";
        $this->db->executeQuery($sql);
    }

    public function delete($id)
    {
        //  TODO: even more validation!!!
        $sql = "UPDATE todo_lists SET is_visible = 0, updated_at = NOW() WHERE id = $id";
        $this->db->executeQuery($sql);
    }
}
