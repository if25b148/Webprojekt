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

        .kurs-details p {
            margin: 0.2rem 0;
        }

        .kurs-link {
            display: inline-block;
            margin-top: 0.5rem;
            text-decoration: none;
            color: #0066cc;
            font-weight: bold;
        }

        .kurs-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body style="background-color:#b0e6c7;">
  <header>
        <a href="../index.html"><img src="../img/logo.png" alt="Logo" class="imglogo"></a>
        <nav>
            <ul>
                <li><a href="kursinfos.php">Kurse</a></li>
                <li><a href="user_page.php">Meine Seite</a></li>
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
                        <div class="kurs-details">
                            <p><strong>Niveau:</strong> <?= htmlspecialchars($course['niveau']) ?></p>
                            <p><strong>Dauer:</strong> <?= htmlspecialchars($course['dauer']) ?></p>
                            <p><strong>Lernmaterialien:</strong> <?= nl2br(htmlspecialchars($course['lernmaterialien'])) ?></p>
                            <?php if(!empty($course['zusatzmaterialien'])): ?>
                                <p><strong>Zusatzmaterialien:</strong> <?= nl2br(htmlspecialchars($course['zusatzmaterialien'])) ?></p>
                            <?php endif; ?>
                            <p><strong>Termin Erstberatung:</strong> <?= nl2br(htmlspecialchars($course['termin_erstberatung'])) ?></p>
                            <p><strong>Ort:</strong> <?= htmlspecialchars($course['ort']) ?></p>
                            <p><strong>Lehrkraft:</strong> <?= htmlspecialchars($course['lehrkraft']) ?></p>
                            <a href="#" class="kurs-link">Zu den Lernmaterialien</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Du bist für derzeit keinen Kurs angemeldet.</p>
            <?php endif; ?>
        </div>
    </section>
  </main>

  <footer>
      <ul>
          <li><a href="datenschutzerklaerung.html">Datenschutzerklärung</a></li>
          <li><a href="agb.html">AGB</a></li>
          <li><a href="kontakt.html">Kontakt</a></li>
          <li><a href="impressum.html">Impressum</a></li>
      </ul>
  </footer>
</body>
</html>
