<?php
session_start();
require_once 'config.php';          //DB-Verbindung laden

if (isset($_POST['reset'])) {       //Prüfen, ob Formular abgeschickt
    $email = $_POST['email'];       //E-Mail aus Formular
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);        //Neues Passwort hashen

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");         //Nutzer prüfen
    if ($result->num_rows > 0) {        //Wenn E-Mail existiert
        $conn->query("UPDATE users SET password='$new_password' WHERE email='$email'");     //Passwort aktualisieren
        $_SESSION['success'] = "Passwort erfolgreich geändert! Sie können sich jetzt einloggen.";       //Erfolgsmeldung
        header("Location: login.php");      //Weiterleitung zum Login
        exit();
    } else {
        $error = "Diese E-Mail ist nicht registriert.";     //Fehlermeldung
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Passwort zurücksetzen</title>
<link rel="stylesheet" href="../css/style.css"> <!-- optional -->
</head>
<body>


<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($_SESSION['success'])) { echo "<p style='color:green;'>".$_SESSION['success']."</p>"; unset($_SESSION['success']); } ?>


<header>
        <a href="..\index.html">
             <img src="../img/logo.png" alt="Logo" class="imglogo">
        </a>
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
<section class="login-section">
    <div class="login-container active" id="forgot-form">
        <h2>Passwort zurücksetzen</h2>

        <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
        <?php if (!empty($_SESSION['success'])) { 
            echo "<p class='success-message'>".$_SESSION['success']."</p>"; 
            unset($_SESSION['success']); 
        } ?>

        <form method="post">
            <label for="email">E-Mail</label>
            <input type="email" name="email" placeholder="beispiel@mail.de" required>

            <label for="new_password">Neues Passwort</label>
            <input type="password" name="new_password" placeholder="********" required>

            <button type="submit" name="reset" class="login-btn">Passwort ändern</button>
        </form>

        <p><a href="login.php" class="forgot-link">Zurück zum Login</a></p>
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
</body>
</html>
