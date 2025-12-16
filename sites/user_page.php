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
    <title>User Page</title>
    <style>
        /* Body & Grundlayout */
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

        /* Section zentrieren */
        .userpagesection {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        /* Box für Inhalte */
        .boxAdminUser {
            background-color: #d3f0e0;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        /* Überschrift */
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

        /* Buttons */
        .boxAdminUser button {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background-color: #006644;
            color: #fff;
            transition: background 0.3s;
        }

        .boxAdminUser button:hover {
            background-color: #004d33;
        }
    </style>
</head>
<body>
    <section class="userpagesection">
        <div class="boxAdminUser">
            <h1>Willkommen, <span><?= htmlspecialchars($_SESSION['vorname']); ?></span></h1>
            <p>Du bist erfolgreich eingeloggt</p>
            <button onclick="window.location.href='logout.php'">Logout</button>
            <button onclick="window.location.href='datenuser.php'">Meine Daten</button>
            <button onclick="window.location.href='kursebuchen.php'">Kurse buchen</button>
        </div>
    </section>
</body>
</html>
