<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {      //Zugriff nur für Admins
    header("Location: login.php");              //Weiterleitung zum Login
    exit();
}

require_once 'config.php';      //DB-Verbindung laden

$message = '';                  //Initialisiert eine leere Variable, die Erfolg oder Fehler anzeigen wird.

if($_SERVER['REQUEST_METHOD'] === 'POST'){          //Formular abgeschickt
    $kurs = trim($_POST['kurs']);
    $niveau = trim($_POST['niveau']);
    $dauer = trim($_POST['dauer']);
    $lernmaterialien = trim($_POST['lernmaterialien']);
    $zusatzmaterialien = trim($_POST['zusatzmaterialien']);
    $termin_erstberatung = trim($_POST['termin_erstberatung']);
    $ort = trim($_POST['ort']);
    $lehrkraft = trim($_POST['lehrkraft']);
    $admin_id = $_SESSION['user_id']; // Admin-ID aus der Session

    if($kurs && $niveau && $dauer && $lernmaterialien && $ort && $lehrkraft){           //Pflichtfelder prüfen, wichtig nicht leer
        $stmt = $conn->prepare("
            INSERT INTO courses 
            (kurs, niveau, dauer, lernmaterialien, zusatzmaterialien, termin_erstberatung, ort, lehrkraft, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");         //Kurs in DB einfügen
        $stmt->bind_param(
            "ssssssssi",
            $kurs, $niveau, $dauer, $lernmaterialien, $zusatzmaterialien, $termin_erstberatung, $ort, $lehrkraft, $admin_id
        );          //werte binden
        if($stmt->execute()){       //Einfügen erfolgreich?
            $message = 'Kurs erfolgreich erstellt!';    //Erfolgsmeldung
        } else {
            $message = 'Fehler beim Erstellen des Kurses: ' . $stmt->error;     //Fehlermeldung
        }
        $stmt->close();
    } else {
        $message = 'Bitte alle Pflichtfelder ausfüllen.';       //Hinweis auf Pflichtfelder
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kurs erstellen</title>

<style>

.page-center {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #b0e6c7;
    font-family: Arial, sans-serif;
}


.formular {
    background: #d3f0e0;
    padding: 30px;
    border-radius: 10px;
    width: 600px;
    box-shadow: 0 0 10px rgba(0,0,0,.1);
}

.formular h1 {
    text-align: center;
    margin-bottom: 20px;
}


.form-message {
    text-align: center;
    font-weight: bold;
    margin-bottom: 15px;
    color: red;
}

.formular label {
    font-weight: bold;
}

.formular input,
.formular textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #aaa;
}

.formular textarea {
    resize: vertical;
    min-height: 80px;
}


.form-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-top: 20px;
}

.btn-primary {
    padding: 12px 20px;
    background-color: #006644;
    color: #ffffff;
    text-decoration: none;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    text-align: center;
}

.btn-primary:hover {
    background-color: #004422;
}

.btn-danger {
    background-color: #cc0000;
}

.btn-danger:hover {
    background-color: #990000;
}
</style>

</head>
<body>

<main class="page-center">
    <div class="formular">

        <h1>Neuen Kurs erstellen</h1>

        <?php if ($message): ?>
            <p class="form-message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Kurs</label>
            <input type="text" name="kurs" required>

            <label>Niveau</label>
            <input type="text" name="niveau" required>

            <label>Dauer</label>
            <input type="text" name="dauer" required>

            <label>Lernmaterialien</label>
            <textarea name="lernmaterialien" required></textarea>

            <label>Zusatzmaterialien</label>
            <textarea name="zusatzmaterialien"></textarea>

            <label>Termin Erstberatung</label>
            <textarea name="termin_erstberatung"></textarea>

            <label>Ort</label>
            <input type="text" name="ort" required>

            <label>Lehrkraft</label>
            <input type="text" name="lehrkraft" required>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Kurs erstellen</button>
                <a href="admin_page.php" class="btn-primary">Zurück</a>
                <a href="logout.php" class="btn-primary btn-danger">Logout</a>
            </div>
        </form>

    </div>
</main>

</body>
</html>
