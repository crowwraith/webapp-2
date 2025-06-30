<?php
$loginIncorrect = false;
session_start();

if(isset($_POST['Login'])) {
    $servername = "mysql_db";
    $username = "root";
    $password = "rootpassword";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e)                                                    {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }

    // Query nu ook role ophalen
    $sql = "SELECT * FROM `gebruikers` WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->execute();
    $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($gebruiker && password_verify($_POST['password'], $gebruiker['password'])) {
        $_SESSION['user_id'] = $gebruiker['id'];
        $_SESSION['username'] = $gebruiker['username'];
        $_SESSION['role'] = $gebruiker['role'];

        if ($gebruiker['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php"); // of een andere pagina voor gewone users
        }
        exit;
    } else {
        $loginIncorrect = true;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <a href="index.php" class="logo">Logo</a>
    <nav class="nav-buttons">
        <a href="ons.php">Over ons</a>
        <a href="reizen.php">reizen</a>
        <a href="contact.php">Service & Contact</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="mijninfo.php">Mijn account</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="admin.php">Admin Panel</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="logout.php">Uitloggen (<?= $_SESSION['username']; ?>)</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<section class="login-container">
    <h2>Login</h2>

    <form method="post" action="">
        <div class="form-group">
            <label for="username">Gebruikersnaam</label>
            <input type="text" id="username" name="username" placeholder="Voer je gebruikersnaam in" required>
        </div>

        <div class="form-group">
            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" placeholder="Voer je wachtwoord in" required>
        </div>

        <button type="submit" class="btn-submit" name="Login">Inloggen</button>
        <a href="account.php" class="btn-login">maak account aan</a>
        <?php
        if ($loginIncorrect) {
            echo '<div class="error">Onjuiste gebruikersnaam of wachtwoord</div>';
        }
        ?>
    </form>
</section>

</body>
</html>
