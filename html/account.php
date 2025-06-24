<?php
// Start sessie
session_start();

// Melding standaard leeg
$melding = "";

// Als het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = $_POST["username"];
    $wachtwoord = $_POST["password"];
    $bevestig = $_POST["password_confirm"];

    // Controleren of alles is ingevuld
    if (empty($gebruikersnaam) || empty($wachtwoord) || empty($bevestig)) {
        $melding = "Vul alle velden in.";
    } elseif ($wachtwoord != $bevestig) {
        $melding = "Wachtwoorden zijn niet gelijk.";
    } else {
        try {
            // Verbinden met database
            $pdo = new PDO("mysql:host=mysql_db;dbname=reisbureau", "root", "rootpassword");

            // Check of gebruiker al bestaat
            $stmt = $pdo->prepare("SELECT * FROM gebruikers WHERE username = ?");
            $stmt->execute([$gebruikersnaam]);

            if ($stmt->rowCount() > 0) {
                $melding = "Gebruikersnaam bestaat al.";
            } else {
                // Gebruiker toevoegen met gehashte wachtwoord
                $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO gebruikers (username, password, role) VALUES (?, ?, 'user')");
                $stmt->execute([$gebruikersnaam, $hashedPassword]);

                $melding = "Account aangemaakt! Je kunt nu <a href='login.php'>inloggen</a>.";
            }
        } catch (PDOException $e) {
            $melding = "Fout met databaseverbinding.";
        }
    }
}
?>

<!-- HTML formulier -->
<!DOCTYPE html>
<html>
<head>
    <title>Registreren</title>
</head>
<body>
<h2>Maak een account</h2>

<!-- Toon melding -->
<?php if (!empty($melding)) echo "<p>$melding</p>"; ?>

<form method="post">
    Gebruikersnaam:<br>
    <input type="text" name="username"><br><br>

    Wachtwoord:<br>
    <input type="password" name="password"><br><br>

    Herhaal wachtwoord:<br>
    <input type="password" name="password_confirm"><br><br>

    <input type="submit" value="Registreren">
</form>

<p><a href="login.php">Terug naar inloggen</a></p>
</body>
</html>
