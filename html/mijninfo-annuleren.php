<?php
session_start();
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";
$currentUser = $_SESSION['user_id'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Optional: validate that it's an integer
    if (is_numeric($id)) {
        $sql = "DELETE FROM boekingen WHERE id = ? AND gebruikerID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $currentUser, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: mijninfo.php?message=deleted");
            exit();
        } else {
            echo "Fout bij annuleren: ";
            print_r($stmt->errorInfo());
        }
    }
}
?>