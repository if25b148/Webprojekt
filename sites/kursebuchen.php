<?php
require 'config.php'; // DB-Verbindung + session_start()

// 1. Prüfen: Nutzer eingeloggt?
if (!isset($_SESSION['user_id'])) {
    die('Bitte zuerst einloggen.');
}

// 2. Prüfen: Kurs-ID vorhanden?
if (!isset($_GET['course_id'])) {
    die('Kein Kurs ausgewählt.');
}

$userId   = $_SESSION['user_id'];
$courseId = $_GET['course_id'];

// 3. Prüfen: Nutzer bereits für den Kurs angemeldet?
$stmt = $pdo->prepare(
    "SELECT 1 FROM enrollments WHERE user_id = ? AND course_id = ?"
);
$stmt->execute([$userId, $courseId]);

if ($stmt->rowCount() === 0) {
    // 4. Anmeldung speichern
    $stmt = $pdo->prepare(
        "INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)"
    );
    $stmt->execute([$userId, $courseId]);
}

// 5. Weiterleitung (z. B. zur Nutzerseite)
header('Location: user_page.php');
exit;
