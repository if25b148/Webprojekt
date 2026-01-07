<?php
require 'config.php'; // DB + session_start()

// 1. Prüfen: Nutzer eingeloggt?
if(!isset($_SESSION['user_id'])){
    die('Bitte zuerst einloggen.');
}

// 2. Prüfen: Kurs-ID vorhanden?
if(!isset($_GET['course_id'])){
    die('Kein Kurs ausgewählt.');
}

$userId = $_SESSION['user_id'];
$courseId = $_GET['course_id'];

// 3. Prüfen: Nutzer ist für den Kurs angemeldet
$stmt = $pdo->prepare("
    SELECT 1 FROM enrollments 
    WHERE user_id = ? AND course_id = ?
");
$stmt->execute([$userId, $courseId]);

if($stmt->rowCount() === 0){
    die('Sie sind für diesen Kurs nicht angemeldet.');
}

// 4. Materialien für den Kurs abrufen
$stmt = $pdo->prepare("
    SELECT * FROM materials 
    WHERE course_id = ?
");
$stmt->execute([$courseId]);
$materials = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materialien</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="background-color:#b0e6c7;">
  <header>
    <a href="../index.html"><img src="../img/logo.png" alt="Logo" class="imglogo"></a>
    <nav>
      <ul>
        <li><a href="kursinfos.php">Kurse</a></li>
        <li><a href="ueberuns.html">Über uns</a></li>
        <li><a href="faq.html">FAQ</a></li>
        <li><a href="kontakt.html">Kontakt</a></li>
        <li><a href="impressum.html">Impressum</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h1>Materialien zum Kurs</h1>
    <?php if(count($materials) === 0): ?>
        <p>Für diesen Kurs sind aktuell keine Materialien verfügbar.</p>
    <?php else: ?>
        <ul>
        <?php foreach($materials as $m): ?>
            <li>
                <?= htmlspecialchars($m['filename']) ?> -
                <a href="<?= htmlspecialchars($m['path']) ?>" download>Herunterladen</a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="kursinfos.php" class="button">Zurück zu den Kursen</a>
  </main>
</body>
</html>
