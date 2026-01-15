<?php
session_start();
require_once 'config.php';

// Admin-Prüfung
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {      //Zugriff nur für Admins
    header("Location: login.php");          //Weiterleitung zum Login
    exit();
}

// Aktionen: löschen, sperren/entsperren
if (isset($_GET['action'], $_GET['user_id'])) {        //Prüft, ob Aktion & User-ID vorhanden sind 
    $user_id = intval($_GET['user_id']);        //User-ID absichern
    if ($_GET['action'] === 'delete') {         //Nutzer löschen
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    } elseif ($_GET['action'] === 'toggle_block') {     //Nutzer sperren / entsperren
        $stmt = $conn->prepare("UPDATE users SET blocked = NOT blocked WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }
}

// Alle Nutzer laden
$result = $conn->query("SELECT id, vorname, nachname, email, role, blocked FROM users ORDER BY id ASC");
$users = $result->fetch_all(MYSQLI_ASSOC);      //Ergebnis als Array speichern
?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Nutzerverwaltung</title>
<style>
body {
    margin:0; padding:0;
    font-family: Arial, sans-serif;
    background:#b0e6c7;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}
.admin-wrapper {
    background:#d3f0e0;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 15px rgba(0,0,0,0.2);
    width:95%;
    max-width:800px;
    text-align:center;
}
.admin-wrapper h1 {
    margin-bottom:20px;
}
table {
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
}
table th, table td {
    border:1px solid #aaa;
    padding:8px;
    text-align:center;
}
table th {
    background:#006644;
    color:#fff;
}
button {
    padding:6px 10px;
    margin:2px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-weight:bold;
    color:#fff;
    background-color:#006644 ;
}
.btn-delete { background:#c0392b; }
.btn-block { background:#e67e22; }
.btn-block.active { background:#27ae60; } /* entsperrt */
</style>
</head>
<body>
<div class="admin-wrapper">
    <h1>Admin - Nutzerverwaltung</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Email</th>
            <th>Rolle</th>
            <th>Status</th>
            <th>Aktionen</th>
        </tr>
        <?php foreach($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['vorname']) ?></td>
            <td><?= htmlspecialchars($user['nachname']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td><?= $user['blocked'] ? 'Gesperrt' : 'Aktiv' ?></td>
            <td>
                <button class="btn-delete" onclick="if(confirm('Wirklich löschen?')) window.location.href='?action=delete&user_id=<?= $user['id'] ?>'">Löschen</button>
                <button class="btn-block <?= $user['blocked'] ? '' : 'active' ?>" onclick="window.location.href='?action=toggle_block&user_id=<?= $user['id'] ?>'">
                    <?= $user['blocked'] ? 'Entsperren' : 'Sperren' ?>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <button onclick="window.location.href='admin_page.php'">Zurück</button>
    <button style="background:#c0392b;color:#fff;" onclick="window.location.href='logout.php'">Logout</button>
</div>
</body>
</html>
