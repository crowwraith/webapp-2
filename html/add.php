<?php
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
    echo "Verbonden met database<br>";
} catch(PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}

// Check of alle velden zijn ingevuld
if (!empty($_POST['naam']) && !empty($_POST['waneer']) && !empty($_POST['van_waar'])
    && !empty($_POST['status']) && !empty($_POST['transfer']) && !empty($_POST['prijs'])) {

    $sql = "INSERT INTO reisjes (naam, waneer, `van waar`, status, transfer, prijs, info)
            VALUES (:naam, :waneer, :van_waar, :status, :transfer, :prijs, :info)";

    $stmt = $conn->prepare($sql);

    // Bind parameters aan de waarden uit het formulier
    $stmt->bindParam(':naam', $_POST['naam']);
    $stmt->bindParam(':waneer', $_POST['waneer']);
    $stmt->bindParam(':van_waar', $_POST['van_waar']);
    $stmt->bindParam(':status', $_POST['status']);
    $stmt->bindParam(':transfer', $_POST['transfer']);
    $stmt->bindParam(':prijs', $_POST['prijs']);
    $stmt->bindParam(':info', $_POST['info']);

    // Voer de query uit
    if ($stmt->execute()) {
        echo "Reis toegevoegd!";
    } else {
        echo "Er ging iets mis met toevoegen.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Reis Toevoegen</title>
</head>
<body>
<h1>Nieuwe reis toevoegen</h1>

<form method="POST" action="">
    <input type="text" name="naam" placeholder="Naam reis" required><br>
    <input type="date" name="waneer" required><br>
    <input type="text" name="van_waar" placeholder="Van waar" required><br>
    <input type="text" name="status" placeholder="Status" required><br>
    <input type="text" name="transfer" placeholder="Transfer" required><br>
    <input type="number" step="0.01" name="prijs" placeholder="Prijs (€)" required><br><br>
    <input type="text" name="info" placeholder="more information" required><br>
    <button type="submit">Toevoegen</button>
</form>

<br>
<a href="admin.php">Terug naar Admin</a>
</body>
</html>
