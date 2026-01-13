<?php
session_start();
require 'config.php'; // DB-Verbindung

// 1. Prüfen: Nutzer eingeloggt?
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// 2. Alle Kurse holen, für die der Nutzer angemeldet ist
$stmt = $conn->prepare("
    SELECT c.*
    FROM courses c
    JOIN enrollments cr ON c.id = cr.course_id
    WHERE cr.user_id = ?
    ORDER BY c.created_at DESC
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
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
        /* Einfache Styles für die Kursübersicht */
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
         color: #0066cc;
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
    </style>
</head>
<body style="background-color:#b0e6c7;">
  <header>
    <img src="../img/logo.png" alt="Logo" class="imglogo">
        <nav>
            <ul>
                <li><a href="kursinfos.php">Kurse</a></li>
                <li><a href="user_page.php">Meine Seite</a></li>
                <li><a href="kontakt.php">Kontakt</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
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
