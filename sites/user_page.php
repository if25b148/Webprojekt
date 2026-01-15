<?php
session_start();
if (!isset($_SESSION['email'])) {           //Prüfen, ob eingeloggt ist
    header("Location: login.php");          //Weiterleitung, falls nicht
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

        .userpagesection {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

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

        .button-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .boxAdminUser button {
            flex: 1;
            min-width: 120px;
            padding: 12px 15px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: #fff;
            transition: background 0.3s, transform 0.2s;
        }

        /* Standardgrüne Buttons */
        .btn-green {
            background-color: #006644;
        }

        .btn-green:hover {
            background-color: #004d33;
            transform: translateY(-2px);
        }

        /* Logout-Button rot */
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
            <h1>Willkommen, <span><?= htmlspecialchars($_SESSION['vorname']); ?></span></h1>
            <p>Du bist erfolgreich eingeloggt</p>

            <div class="button-container">
                <!-- Logout Button -->
                <button class="btn-red" onclick="window.location.href='logout.php'">Logout</button>

                <!-- Andere Aktionen -->
                <button class="btn-green" onclick="window.location.href='datenuser.php'">Meine Daten</button>
                <button class="btn-green" onclick="window.location.href='meine_kurse.php'">Meine Kurse</button>
            </div>
        </div>
    </section>
</body>
</html>
