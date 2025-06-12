<?php
session_start();            // Start de sessie
session_unset();            // Verwijder alle sessie-variabelen
session_destroy();          // Vernietig de sessie

header("Location: login.php"); // Stuur terug naar loginpagina
exit;
?>
