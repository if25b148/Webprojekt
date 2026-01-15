<?php
require 'config.php'; // DB-Verbindung einbinden

// Alle Kurse aus der DB abrufen
$result = $conn->query("SELECT * FROM courses ORDER BY created_at DESC");

$courses = [];
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $courses[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprachkursbuchung</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header>
        <a href="../index.html"><img src="../img/logo.png" alt="Logo" class="imglogo"></a>
        <nav>
            <ul>
                <li><a href="kursinfos.php">Kurse</a></li>
                <li><a href="ueberuns.html">Über uns</a></li>
                <li><a href="faq.html">FAQ</a></li>
                <li><a href="kontakt.php">Kontakt</a></li>
                <li><a href="impressum.html">Impressum</a></li>
                <li><a href="login.php" class="anmeldenlink">Login</a></li>
            </ul>
        </nav>
  </header>
<main>
    <section>
        <h1 class="h2angeboteKurse">Angebotene Kurse</h1>

        <div class="kurs-grid">
            <?php if(!empty($courses)): ?>
                <?php foreach($courses as $course): ?>
                    <div class="kurs-box kurs-item">

                        <!-- Sichtbar: Kursname -->
                        <div class="kurs-title">
                            <?= htmlspecialchars($course['kurs']) ?>
                        </div>

                        <!-- Versteckt: Details -->
                        <div class="kurs-details">
                            <p><strong>Niveau:</strong> <?= htmlspecialchars($course['niveau']) ?></p>
                            <p><strong>Dauer:</strong> <?= htmlspecialchars($course['dauer']) ?></p>
                            <p><strong>Lernmaterialien:</strong> <?= nl2br(htmlspecialchars($course['lernmaterialien'])) ?></p>
                            <p><strong>Zusatzmaterialien:</strong> <?= nl2br(htmlspecialchars($course['zusatzmaterialien'])) ?></p>
                            <p><strong>Termin Erstberatung:</strong> <?= nl2br(htmlspecialchars($course['termin_erstberatung'])) ?></p>
                            <p><strong>Ort:</strong> <?= htmlspecialchars($course['ort']) ?></p>
                            <p><strong>Lehrkraft:</strong> <?= htmlspecialchars($course['lehrkraft']) ?></p>
                        </div>

                        <p>
                            <a href="kursebuchen.php?course_id=<?= $course['id'] ?>" class="HomeBuchen">Jetzt buchen</a>
                        </p>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Es sind derzeit keine Kurse verfügbar.</p>
            <?php endif; ?>
        </div>
    </section>
  </main>

  <footer>
      <ul>
          <li><a href="datenschutzerklaerung.html">Datenschutzerklärung</a></li>
          <li><a href="agb.html">AGB</a></li>
          <li><a href="kontakt.php">Kontakt</a></li>
          <li><a href="impressum.html">Impressum</a></li>
      </ul>
  </footer>
<script src="script.js"></script>
</body>
</html>