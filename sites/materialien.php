<?php
session_start();
require_once 'config.php';

/* Nur Admin */
if (!isset($_SESSION['email']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit;
}

/* Kurse laden */
$courses = $conn->query("SELECT id, kurs FROM courses");

/* Upload-Logik */
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $course_id = intval($_POST['course_id']);

    $allowedTypes = [
    'application/pdf',
    'application/zip',
    'application/x-zip-compressed',
    'multipart/x-zip',
    'application/octet-stream',
    'image/jpeg',
    'image/png',
    'audio/mpeg',
    'audio/wav'
];

    if (!isset($_FILES['material']) || $_FILES['material']['error'] !== 0) {
        $message = "Datei-Upload fehlgeschlagen.";
    } else {

        $file = $_FILES['material'];

        if (!in_array($file['type'], $allowedTypes)) {
            $message = "Dateityp nicht erlaubt.";
        } else {

            /* Kurs-Ordner definieren */
            $courseDir = __DIR__ . "/uploads/courses/course_" . $course_id . "/";

            /* Ordner anlegen, falls nicht vorhanden */
            if (!is_dir($courseDir)) {
                mkdir($courseDir, 0755, true);
            }

            /* Sicherer Dateiname */
            $safeName = time() . "_" . basename($file['name']);

            /* Server-Zielpfad */
            $targetPath = $courseDir . $safeName;

            /* Pfad für Datenbank (relativ!) */
            $dbPath = "uploads/courses/course_$course_id/" . $safeName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {

                $stmt = $conn->prepare(
                    "INSERT INTO materials (course_id, filename, filepath, filetype)
                     VALUES (?, ?, ?, ?)"
                );

                $stmt->bind_param(
                    "isss",
                    $course_id,
                    $file['name'],
                    $dbPath,
                    $file['type']
                );

                $stmt->execute();

                $message = "Material erfolgreich hochgeladen.";
            } else {
                $message = "Datei konnte nicht gespeichert werden.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kursmaterialien hochladen</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<main class="internbuchung">
    <div class="internbuchung-box">
        <h1>Kursmaterial hochladen</h1>

        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <label><strong>Kurs auswählen:</strong></label><br><br>

            <select name="course_id" required>
                <?php while ($c = $courses->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>">
                        <?= htmlspecialchars($c['kurs']) ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <input type="file" name="material" required><br><br>

            <button type="submit" class="HomeBuchen">Hochladen</button>
            <a href="admin_page.php" class="HomeBuchen">Zurück zur Übersicht</a>

  
        </form>
    </div>
</main>

</body>
</html>
