<?php
require 'config.php';       //DB-Verbindung laden
session_start();

$courseId = $_GET['course_id'] ?? null;     //Kurs-ID aus URL holen, wenn id nicht gesetzt ist, dann null gesetzt

if (!$courseId) {           //Prüft, ob Kurs-ID vorhanden ist (Leer oder null)
    die('Kein Kurs ausgewählt.');       //Abbruch bei fehlender Kurs-ID
}

// Prüfen, ob der Nutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {     //Login-Status prüfen, Wenn keine User-ID in der Session ist, Nutzer ist nicht eingeloggt.
    // Zur Login-Seite mit Rückkehr zur Buchung
    header("Location: login.php?return_url=" . urlencode("kursebuchen.php?course_id=$courseId"));       //Weiterleitung mit Rücksprung
    exit(); //urlencode() kodiert die URL, sodass sie sicher als GET-Parameter übergeben werden kann.
}

$userId = $_SESSION['user_id'];         //Aktuelle User-ID, gebruacht um zu schauen, ob nutzer Kurs schon gebucht hat

// Prüfen, ob der Nutzer bereits angemeldet ist
$stmt = $conn->prepare("SELECT 1 FROM enrollments WHERE user_id = ? AND course_id = ?");         //Anmeldung prüfen
$stmt->bind_param("ii", $userId, $courseId);    //Parameter binden
$stmt->execute();                               //Query ausführen
$result = $stmt->get_result();                  //Ergebnis holen

if ($result->num_rows === 0) {                  //Gibtes keine Buchung für den Nutzer und Kurs?
    $stmt = $conn->prepare("INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)");       //Kurs buchen
    $stmt->bind_param("ii", $userId, $courseId);    //Werte binden
    $stmt->execute();                           //Eintrag speichern
}

$stmt->close();

// Weiterleitung nach Buchung
header("Location: meine_kurse.php");            //Zur Kursübersicht
exit();
