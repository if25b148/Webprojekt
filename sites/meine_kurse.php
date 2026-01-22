<?php
session_start();
require 'config.php'; //DB-Verbindung laden

// 1. Prüfen: Nutzer eingeloggt?
if (!isset($_SESSION['user_id'])) {     //Login prüfen
    header("Location: login.php");      //Bei nicht eingeloggt weiterleiten
    exit();
}

$userId = $_SESSION['user_id'];         //Aktuelle User-ID

// 2. Alle Kurse holen, für die der Nutzer angemeldet ist
$stmt = $conn->prepare("
    SELECT c.*
    FROM courses c
    JOIN enrollments cr ON c.id = cr.course_id
    WHERE cr.user_id = ?
    ORDER BY c.created_at DESC
");         //SQL-Abfrage vorbereiten
$stmt->bind_param("i", $userId);        //Parameter binden
$stmt->execute();                       //Query ausführen
$result = $stmt->get_result();          //Ergebnis holen

$courses = [];                          //Array für Kurse
if ($result->num_rows > 0) {            //Wenn Kurse vorhanden
    while ($row = $result->fetch_assoc()) {     //Durchlaufen
        $courses[] = $row;              //In Array speichern.
    }
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Kurse</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* css */
        .kurs-grid {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .kurs-box {
            background-color: #fff;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

       .kurs-box h3 {
         margin: 0 0 0.5rem 0;
        }

        .kurs-link {
         display: inline-block;
         text-decoration: none;
         color: #006644;
        font-weight: bold;
    }

        .kurs-link:hover {
            text-decoration: underline;
        }
        .meineKursephp{
            padding: 1rem;
            border-radius: 8px;
            margin-top: 10rem;

        }

       .section-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.action-btn {
    padding: 0.6rem 1.2rem;
    border-radius: 6px;
    background-color: #006644;
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
}

.action-btn:hover {
    background-color: #006644;
}

.logout-btn {
    background-color: #ff0000;
}

.logout-btn:hover {
    background-color: #990000;
}





    </style>
</head>
<body style="background-color:#b0e6c7;">
  <header>
        <nav>
            
        </nav>
  </header>

  <main>
    <section>
        <h1>Meine Kurse</h1>

        <div class="kurs-grid">
            <?php if(!empty($courses)): ?>
                <?php foreach($courses as $course): ?>
                    <div class="kurs-box">
                        <h3><?= htmlspecialchars($course['kurs']) ?></h3>
                        <a href="user_materialienzugriff.php?course_id=<?= $course['id'] ?>" class="kurs-link">
                            Zu den Lernmaterialien
                        </a>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <p>Du bist für derzeit keinen Kurs angemeldet.</p>
                <?php endif; ?>
        </div>
        <div class="section-actions">
            <a href="user_page.php" class="action-btn">Zurückzur Übersicht</a>
             <a href="kursinfos.php" class="action-btn">Vorhandene Kurse</a>
            <a href="logout.php" class="action-btn logout-btn">Logout</a>
         </div>


    </section>
   <aside>
    <div class="meineKursephp"">
        <h2>Hinweis</h2>
        <p>
            Falls du Probleme beim Zugriff auf deine Kurse hast,
            <a href="kontakt.php">kontaktiere</a> bitte unseren Support.
        </p>
    </div>
    </aside>

    </main>
</body>
</html>
