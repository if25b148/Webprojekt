<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Page</title>

<style>
/* ===== BODY / SEITE ===== */
body {
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: Arial, sans-serif;
    background-color: #b0e6c7;
}

/* ===== SECTION / WRAPPER ===== */
.userpagesection {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

/* ===== CARD / BOX ===== */
.boxAdminUser {
    background-color: #d3f0e0;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    text-align: center;
    max-width: 500px;
    width: 90%;
}

.boxAdminUser h1 {
    margin-bottom: 15px;
    font-size: 24px;
    color: #261d1d;
}

.boxAdminUser span {
    font-weight: bold;
}

.boxAdminUser p {
    margin-bottom: 25px;
    font-size: 16px;
    color: #3a5f4e;
}

/* ===== BUTTON CONTAINER ===== */
.button-container {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap; /* Buttons umbrechen bei kleinen Bildschirmen */
}

/* ===== BUTTONS ===== */
.boxAdminUser .btn {
    flex: 1;
    min-width: 120px;
    padding: 12px 15px;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    color: #fff;
    text-align: center;
    text-decoration: none;

}

/* Grün = Aktionen */
.btn-green {
    background-color: #006644;
}

.btn-green:hover {
    background-color: #004d33;
    
}

/* Rot = Logout */
.btn-red {
    background-color: #c0392b;
}

.btn-red:hover {
    background-color: #a93226;
    transform: translateY(-2px);
}
</style>
</head>
<body>

<section class="userpagesection">
    <div class="boxAdminUser">
        <h1>Willkommen, <span><?= htmlspecialchars($_SESSION['role'] . ' ' . $_SESSION['vorname']); ?></span></h1>
        <p>Du bist erfolgreich eingeloggt</p>

        <div class="button-container">
            <a href="logout.php" class="btn btn-red">Logout</a>
            <a href="admindatenverwaltung.php" class="btn btn-green">User Daten verwalten</a>
            <a href="kurseerstellen.php" class="btn btn-green">Kurse erstellen</a>
            <a href="materialien.php" class="btn btn-green">Kursmaterialien hochladen</a>
        </div>

    </div>
</section>

</body>
</html>