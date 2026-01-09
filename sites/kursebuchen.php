<?php
require 'config.php';
session_start();

$courseId = $_GET['course_id'] ?? null;

if (!$courseId) {
    die('Kein Kurs ausgewählt.');
}

// Prüfen, ob der Nutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    // Zur Login-Seite mit Rückkehr zur Buchung
    header("Location: login.php?return_url=" . urlencode("kursebuchen.php?course_id=$courseId"));
    exit();
}

$userId = $_SESSION['user_id'];

// Prüfen, ob der Nutzer bereits angemeldet ist
$stmt = $conn->prepare("SELECT 1 FROM course_registrations WHERE user_id = ? AND course_id = ?");
$stmt->bind_param("ii", $userId, $courseId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt = $conn->prepare("INSERT INTO course_registrations (user_id, course_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $courseId);
    $stmt->execute();
}

$stmt->close();

// Weiterleitung nach Buchung
header("Location: meine_kurse.php");
exit();
