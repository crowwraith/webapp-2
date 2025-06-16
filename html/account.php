<?php
session_start();
$m = '';
$a = false;

if ($_POST) {
    $u = $_POST['username'] ;
    $p = $_POST['password'] ;
    if (!$u || !$p || !$pc) $m = 'Vul alles in.';
    elseif ($p !== $pc) $m = 'Wachtwoorden verschillen.';
    else {
        try {
            $db = new PDO("mysql:host=mysql_db;dbname=reisbureau", "root", "rootpassword");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $c = $db->prepare("SELECT COUNT(*) FROM gebruikers WHERE username=?");
            $c->execute([$u]);
            if ($c->fetchColumn()) $m = 'Gebruiker bestaat al.';
            else {
                $i = $db->prepare("INSERT INTO gebruikers (username, password, role) VALUES (?, ?, 'user')");
                $i->execute([$u, $p]);
                $a = true;
            }
        } catch (PDOException $e) {
            $m = 'DB fout.';
        }
    }
}
?>
<?php if ($a): ?>
    <p style="color:green">Account gemaakt! <a href="login.php">Login</a></p>
<?php else: ?>
    <?php if ($m): ?><p style="color:red"><?= $m ?></p><?php endif; ?>
    <form method="post">
        Gebruikersnaam:<br><input name="username"><br><br>
        Wachtwoord:<br><input type="password" name="password"><br><br>
        Bevestig wachtwoord:<br><input type="password" name="password_confirm"><br><br>
        <button>Maak account</button>
    </form>
    <p><a href="login.php">Terug</a></p>
<?php endif; ?>
