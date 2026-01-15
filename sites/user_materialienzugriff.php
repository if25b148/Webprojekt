<?php
session_start();
require 'config.php';             //DB-Verbindung laden

// 1. Prüfen: User eingeloggt?
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");          //Weiterleitung, wenn nicht eingeloggt
    exit();
}

$userId = $_SESSION['user_id'];             //User-ID speichern

// 2. Prüfen: course_id über GET?
if (!isset($_GET['course_id'])) {
    echo "Kein Kurs ausgewählt.";           //Fehlermeldung
    exit();
}

$courseId = intval($_GET['course_id']);     //course_id sichern

// 3. Prüfen: Ist der User für diesen Kurs eingeschrieben?
$stmt = $conn->prepare("
    SELECT c.kurs 
    FROM courses c
    JOIN enrollments e ON c.id = e.course_id
    WHERE c.id = ? AND e.user_id = ?
");
$stmt->bind_param("ii", $courseId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {              //Wenn nicht eingeschrieben
    echo "Du bist für diesen Kurs nicht angemeldet oder der Kurs existiert nicht.";
    exit();
}

$course = $result->fetch_assoc();           //Kursdaten speichern
$stmt->close();

// 4. Alle Materialien für diesen Kurs holen
$stmt = $conn->prepare("
    SELECT filename, filepath, filetype 
    FROM materials 
    WHERE course_id = ?
    ORDER BY id ASC
");
$stmt->bind_param("i", $courseId);
$stmt->execute();
$materials = $stmt->get_result();           //Materialien speichern
$stmt->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Materialien für <?= htmlspecialchars($course['kurs']) ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        main {
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }

        h1 {
            color: #261d1d;
        }

        .material-box {
            background: #d3f0e0;
            padding: 20px 25px;
            border-radius: 10px;
            width: 80%;
            max-width: 700px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .material-name {
            font-weight: bold;
            color: #3a5f4e;
            word-break: break-word;
        }

        .material-buttons {
            display: flex;
            gap: 10px;
        }

        .material-buttons a {
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            color: #fff;
            transition: background 0.3s;
        }

        .btn-view { background-color: #006644; }
        .btn-view:hover { background-color: #004d33; }

        .btn-download { background-color: #877c77eb; }
        .btn-download:hover { background-color: #554c48eb; }

        p.no-material {
            color: #a42834;
            font-weight: bold;
        }


        .button-row {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.button-row a {
    padding: 12px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    color: #fff;
    text-align: center;
    transition: background 0.3s, transform 0.2s;
}

.button-row .btn-green {
    background-color: #006644;
}

.button-row .btn-green:hover {
    background-color: #004d33;
    transform: translateY(-2px);
}

.button-row .btn-red {
    background-color: #c0392b;
}

.button-row .btn-red:hover {
    background-color: #a93226;
    transform: translateY(-2px);
}

    </style>
</head>
<body style="background-color:#b0e6c7;">

<header>
   
    <nav>
       
    </nav>
</header>

<main>
    <h1>Materialien für Kurs: <?= htmlspecialchars($course['kurs']) ?></h1>

    <?php if($materials->num_rows > 0): ?>
        <?php while($mat = $materials->fetch_assoc()): ?>
            <div class="material-box">
                <div class="material-name"><?= htmlspecialchars($mat['filename']) ?></div>
                <div class="material-buttons">
                    <a href="<?= htmlspecialchars($mat['filepath']) ?>" target="_blank" class="btn-view">Anzeigen</a>
                    <a href="<?= htmlspecialchars($mat['filepath']) ?>" download class="btn-download">Herunterladen</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="no-material">Für diesen Kurs wurden noch keine Materialien hochgeladen.</p>
    <?php endif; ?>

    
    <div class="button-row">
        <a href="meine_kurse.php" class="btn-green">Zurück zu meinen Kursen</a>
        <a href="logout.php" class="btn-red">Logout</a>
    </div>
</main>

</body>
</html>
