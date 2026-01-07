<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $kurs = trim($_POST['kurs']);
    $niveau = trim($_POST['niveau']);
    $dauer = trim($_POST['dauer']);
    $lernmaterialien = trim($_POST['lernmaterialien']);
    $zusatzmaterialien = trim($_POST['zusatzmaterialien']);
    $termin_erstberatung = trim($_POST['termin_erstberatung']);
    $ort = trim($_POST['ort']);
    $lehrkraft = trim($_POST['lehrkraft']);
    $admin_id = $_SESSION['user_id']; // Admin-ID aus der Session

    if($kurs && $niveau && $dauer && $lernmaterialien && $ort && $lehrkraft){
        $stmt = $conn->prepare("
            INSERT INTO courses 
            (kurs, niveau, dauer, lernmaterialien, zusatzmaterialien, termin_erstberatung, ort, lehrkraft, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssssssssi",
            $kurs, $niveau, $dauer, $lernmaterialien, $zusatzmaterialien, $termin_erstberatung, $ort, $lehrkraft, $admin_id
        );
        if($stmt->execute()){
            $message = 'Kurs erfolgreich erstellt!';
        } else {
            $message = 'Fehler beim Erstellen des Kurses: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = 'Bitte alle Pflichtfelder ausfüllen.';
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurs erstellen</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="background-color:#b0e6c7;">
  <header>
    <a href="../index.html"><img src="../img/logo.png" alt="Logo" class="imglogo"></a>
    <nav>
      <ul>
        <li><a href="admin_page.php">Admin</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h1>Neuen Kurs erstellen</h1>

    <?php if($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post">
    <label>Kurs:</label><br>
    <input type="text" name="kurs" required><br><br>

    <label>Niveau:</label><br>
    <input type="text" name="niveau" required><br><br>

    <label>Dauer:</label><br>
    <input type="text" name="dauer" required><br><br>

    <label>Lernmaterialien:</label><br>
    <textarea name="lernmaterialien" required></textarea><br><br>

    <label>Zusatzmaterialien:</label><br>
    <textarea name="zusatzmaterialien"></textarea><br><br>

    <label>Termin Erstberatung:</label><br>
    <textarea name="termin_erstberatung"></textarea><br><br>

    <label>Ort:</label><br>
    <input type="text" name="ort" required><br><br>

    <label>Lehrkraft:</label><br>
    <input type="text" name="lehrkraft" required><br><br>

    <button type="submit">Kurs erstellen</button>
</form>

  </main>
</body>
</html>
