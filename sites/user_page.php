<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>





<! DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
   <link rel="stylesheet" href="..\css\style.css">
</head>

<body>

    <section class="userpagesection">
        <div class="boxAdminUser">
            <h1>Willkommen, <span><?= $_SESSION['vorname']; ?></span></h1>
            <p>Du bist erfolgreich eingelogt</p>
            <button onclick=window.location.href='logout.php'>Logout</button>
            <button onclick="window.location.href='datenuser.php'">Meine Daten</button>
            <button onclick="window.location.href='kursebuchen.php'">Kurse buchen</button>

        </div>
    </section>

</body>
</html>