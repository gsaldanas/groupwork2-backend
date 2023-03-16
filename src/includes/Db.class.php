<?php
require_once 'env.php';

class Db
{

    // Database configuration
    private $db_host = DB_HOST;
    private $db_name = DB_NAME;
    private $db_user = DB_USER;
    private $db_password = DB_PASSWORD;
    private $port = 3306;
    private $pdo;

    // Create a new PDO instance
    public function __construct()
    {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO(
                    "mysql:host=" . $this->db_host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                    $this->db_user,
                    $this->db_password
                );
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                return null;
            }
        }
    }

    public function executeQuery($sql, $fields = [], $fetch = PDO::FETCH_OBJ)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($fields);
        return $stmt->fetchAll($fetch);
    }
}
