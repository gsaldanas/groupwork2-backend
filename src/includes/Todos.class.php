<?php

class Todos
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    private function buildWhere($filters)
    {
        $where = '';
        if (count($filters)) {
            $where = [];
            foreach ($filters as $key => $value) {
                $where[] = "$key = :$key";
            }
            $where = 'WHERE ' . implode(' AND ', $where);
        }
        return $where;
    }

    public function getAll($filter = [])
    {
        $where = $this->buildWhere($filter);
        $sql = "SELECT * FROM todos $where";
        return $this->db->executeQuery($sql, $filter);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM todos WHERE id=:id AND is_visible = 1";
        return $this->db->executeQuery($sql, ['id' => $id]);
    }
    public function add($data)
    {
        // Define the valid fields for the todos table
        $validFields = ['title','todo_lists_id'];
    
        // Check that all keys in $data are valid fields
        $invalidFields = array_diff(array_keys($data), $validFields);
        if (!empty($invalidFields)) {
            throw new InvalidArgumentException('Invalid field(s) provided: ' . implode(', ', $invalidFields));
        }
    
        // Check that all required fields are present
        $requiredFields = ['title'];
        $missingFields = array_diff($requiredFields, array_keys($data));
        if (!empty($missingFields)) {
            throw new InvalidArgumentException('Missing required field(s): ' . implode(', ', $missingFields));
        }
    
        // Insert the data into the database
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
