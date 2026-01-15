<?php
session_start();
if (empty($_SESSION['email'])) {        //Prüft Login-Status
    header("Location: login.php");      //Weiterleitung zum Login
    exit;
}

require_once 'config.php';              //DB-Verbindung laden

$user_email = $_SESSION['email'];       //Aktuelle User-E-Mail
$message = "";                          //Statusmeldung

/* User-Daten laden */
$stmt = $conn->prepare(
    "SELECT vorname, nachname, email, password FROM users WHERE email = ?"      //User-Daten abfragen
);
$stmt->bind_param("s", $user_email);    //E-Mail binden
$stmt->execute();                       //Query ausführen
$user = $stmt->get_result()->fetch_assoc();     //Ergebnis speichern

/* Formular absenden */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {    //Prüft Formular-Submit
    $vorname  = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $email    = $_POST['email'];

    $password = !empty($_POST['passwort'])      //Passwort geändert?
        ? password_hash($_POST['passwort'], PASSWORD_DEFAULT)   //Neues Passwort hashen       
        : $user['password'];            //Altes Passwort behalten

    $stmt = $conn->prepare(
        "UPDATE users SET vorname=?, nachname=?, email=?, password=? WHERE email=?"         //User aktualisieren
    );
    $stmt->bind_param("sssss", $vorname, $nachname, $email, $password, $user_email);        //Werte binden

    if ($stmt->execute()) {             //Update erforderlich?
    $_SESSION['email'] = $email;        //Session-E-Mail aktualisieren
    $user_email = $email;               //Lokale E-Mail aktualisieren

    // $user sauber aktualisieren, password behalten
    $user['vorname']  = $vorname;
    $user['nachname'] = $nachname;
    $user['email']    = $email;
    // $user['password'] bleibt unverändert, falls nicht geändert

    $message = "Daten erfolgreich aktualisiert!";
    } else {
        $message = "Fehler beim Aktualisieren der Daten!";
    }
}
?>


<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meine Daten</title>

<style>
body {
    margin: 0;
    background: #b0e6c7;
    font-family: Arial, sans-serif;
}

.datenuser-wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.datenuser-box {
    background: #d3f0e0;
    padding: 30px;
    border-radius: 10px;
    width: 500px;
    box-shadow: 0 0 10px rgba(0,0,0,.1);
}

h1 {
    text-align: center;
    margin-bottom: 15px;
}

.message {
    text-align: center;
    font-weight: bold;
    margin-bottom: 15px;
    color: red;
}

.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.form-group {
    flex: 1;
}

label {
    font-weight: bold;
}

input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #aaa;
}

.btnuserdaten {
    width: 100%;
    margin-top: 20px;
    padding: 12px;
    background: #006644;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.btnuserdaten:hover {
    background: #554c48eb;
}

.button-row {
    display: flex;
    justify-content: space-between; /* links und rechts */
    margin-top: 20px;
    gap: 10px; /* Abstand zwischen den Buttons */
}

.btn-secondary {
    display: inline-block;
    padding: 10px 20px;
    background-color: #006644;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
    text-align: center;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-secondary:hover {
    background-color: #004422;
}

.logout-btn {
    background-color: #cc0000;
}

.logout-btn:hover {
    background-color: #990000;
}


</style>
</head>

<body>
<section class="datenuser-wrapper">
<div class="datenuser-box">

<h1>Meine Daten</h1>

<?php if ($message): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="post">
    <div class="form-row">
        <div class="form-group">
            <label>Vorname</label>
            <input name="vorname" value="<?= htmlspecialchars($user['vorname']) ?>" required>
        </div>
        <div class="form-group">
            <label>Nachname</label>
            <input name="nachname" value="<?= htmlspecialchars($user['nachname']) ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>E-Mail</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="form-group">
            <label>Passwort</label>
            <input type="password" name="passwort">
        </div>
    </div>

    <button class="btnuserdaten">Daten speichern</button>
    <div class="button-row">
    <a href="user_page.php" class="btn-secondary">Zurück zur Übersicht</a>
    <a href="logout.php" class="btn-secondary logout-btn">Logout</a>
</div>
</form>

</div>
</section>
</body>
</html>
