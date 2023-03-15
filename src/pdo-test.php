<?php
// Database credentials withouth getting from .env
$db_host = 'replace with combell credentials';
$db_name = 'replace with combell credentials';
$db_user = 'replace with combell credentials';
$db_pass = 'replace with combell credentials';

// PDO connection
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";

    // Fetch all data from a table
    $stmt = $conn->prepare("SELECT * FROM todos");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the result in a var_dump() function
    echo '<pre>';
    var_dump($result);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>
