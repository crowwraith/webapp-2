<?php session_start(); ?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>

<header class="mobile-header">
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

<div class="achtergrond-container">
    <img src="/assets/img/achtergrond.png" alt="Achtergrond afbeelding" class="achtergrond" />

    <form class="zoek-form">
        <label>
            Vertrekdatum
            <input type="date" name="vertrekdatum" required />
        </label>

        <label>
            Reistduur (dagen)
            <input type="number" name="reistduur" min="1" required />
        </label>

        <label>
            Aantal reizigers
            <select name="reizigers" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </label>

        <button type="submit">Zoeken</button>
    </form>
</div>

<section class="foto-en-balkjes-container">

    <div class="foto-grid">
        <img src="/assets/img/foto1.png" alt="Foto 1" />
        <img src="/assets/img/foto2.png" alt="Foto 2" />
        <img src="/assets/img/foto3.png" alt="Foto 3" />
        <img src="/assets/img/foto4.png" alt="Foto 4" />
    </div>

    <div class="balkjes-container">
        <div class="balk">Reizen boeken</div>
        <div class="balk">Scherp geprijsde vakanties</div>
        <div class="balk">Stedentrips</div>
        <div class="balk">Wintersport</div>
        <div class="balk">Autovakanties </div>
        <div class="balk">Verre reizen</div>
        <div class="balk">Rondreizen</div>
        <div class="balk">Groups& incentives</div>
        <div class="balk">Wekelijkse deals</div>
    </div>

</section>

<footer>
    <nav>
        <a href="index.php" class="Home">Home</a>
        <a href="contact.php">Service & Contact</a>
        <a href="policy.php">Policy</a>
    </nav>



</footer>

</body>
</html>
