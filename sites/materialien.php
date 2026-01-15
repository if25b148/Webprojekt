<?php
session_start();
require_once 'config.php';              //DB-Verbindung laden

/* Nur Admin */
if (!isset($_SESSION['email']) || ($_SESSION['role'] ?? '') !== 'admin') {      //Admin prüfen
    header("Location: login.php");              //Bei Nicht-Admin weiterleiten
    exit;
}

/* Kurse laden */
$courses = $conn->query("SELECT id, kurs FROM courses");        //Alle Kurse abrufen

/* Upload-Logik */
$message = "";              //Meldung initialisieren

if ($_SERVER['REQUEST_METHOD'] === 'POST') {            //Prüft, ob Formular abgeschickt

    $course_id = intval($_POST['course_id']);           //Kurs-ID

    $allowedTypes = [               //erlaubte Dateitypen
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

    if (!isset($_FILES['material']) || $_FILES['material']['error'] !== 0) {        //Datei-Fehler prüfen
        $message = "Datei-Upload fehlgeschlagen.";          //Fehlermeldung
    } else {

        $file = $_FILES['material'];                        //Datei-Array

        if (!in_array($file['type'], $allowedTypes)) {      //Typ prüfen
            $message = "Dateityp nicht erlaubt.";           //Fehlermeldung
        } else {

            /* Kurs-Ordner definieren */
            $courseDir = __DIR__ . "/uploads/courses/course_" . $course_id . "/";       //Zielordner

            /* Ordner anlegen, falls nicht vorhanden */
            if (!is_dir($courseDir)) {
                mkdir($courseDir, 0755, true);      //Ordner erstellen
            }

            /* Sicherer Dateiname */
            $safeName = time() . "_" . basename($file['name']);     //Zeit+Originalname

            /* Server-Zielpfad */
            $targetPath = $courseDir . $safeName;           //Vollständiger Pfad

            /* Pfad für Datenbank (relativ!) */
            $dbPath = "uploads/courses/course_$course_id/" . $safeName;         //Relativer Pfad

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {           //Datei verschieben

                $stmt = $conn->prepare(
                    "INSERT INTO materials (course_id, filename, filepath, filetype)
                     VALUES (?, ?, ?, ?)"       //Eintrag in DB
                );

                $stmt->bind_param(
                    "isss",
                    $course_id,
                    $file['name'],
                    $dbPath,
                    $file['type']
                );

                $stmt->execute();           //Datenbank speichern

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
