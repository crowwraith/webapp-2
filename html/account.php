<?php
session_start();

$accountAangemaakt = false;
$foutmelding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $role = $_POST['role'] ?? 'user'; // standaard rol 'user'

    if (!$username || !$password || !$password_confirm) {
        $foutmelding = 'Vul alle velden in.';
    } elseif ($password !== $password_confirm) {
        $foutmelding = 'Wachtwoorden komen niet overeen.';
    } elseif (!in_array($role, ['user', 'admin'])) {
        $foutmelding = 'Ongeldige rol geselecteerd.';
    } else {
        try {
            $conn = new PDO("mysql:host=mysql_db;dbname=reisbureau", "root", "rootpassword");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $check = $conn->prepare("SELECT COUNT(*) FROM gebruikers WHERE username = ?");
            $check->execute([$username]);

            if ($check->fetchColumn() > 0) {
                $foutmelding = 'Gebruikersnaam bestaat al.';
            } else {
                $insert = $conn->prepare("INSERT INTO gebruikers (username, password, role) VALUES (?, ?, ?)");
                $insert->execute([$username, $password, $role]);
                $accountAangemaakt = true;
            }
        } catch (PDOException $e) {
            $foutmelding = "Fout met database: " . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Account aanmaken</title>
</head>
<body>

<h2>Maak een nieuw account aan</h2>

<?php if ($accountAangemaakt): ?>
    <p style="color:green;">Account succesvol aangemaakt! <a href="login.php">Log nu in</a></p>
<?php else: ?>
    <?php if ($foutmelding): ?>
        <p style="color:red;"><?= htmlspecialchars($foutmelding) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Gebruikersnaam:</label><br>
        <input name="username" required><br><br>

        <label>Wachtwoord:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Bevestig wachtwoord:</label><br>
        <input type="password" name="password_confirm" required><br><br>



        <button type="submit">Account maken</button>
    </form>

    <p><a href="login.php">Terug naar login</a></p>
<?php endif; ?>

</body>
</html>
