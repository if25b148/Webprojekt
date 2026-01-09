<?php
session_start();

// Login-Pflicht
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Gewählten Kurs aus URL holen
$kurs = $_GET['kurs'] ?? 'Kein Kurs gewählt';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kurs buchen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\style.css">
</head>
<body>

<main class="internbuchung">
    <div class="internbuchung-box">
        <h1>Kurs buchen</h1>

        <p class="internkurs-name">
            <strong>Gewählter Kurs:</strong><br>
            <?= htmlspecialchars($kurs) ?>
        </p>

        <form method="post" action="#">
            <button type="submit" class="HomeBuchen">
                Buchung bestätigen
            </button>
        </form>
    </div>
</main>

</body>
</html>
