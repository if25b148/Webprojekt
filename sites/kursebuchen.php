
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$kurs = $_GET['kurs'] ?? 'Kein Kurs gewählt';
?>
