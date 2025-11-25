<?php

session_start();

$errors = 
[
'login' => $_SESSION['login_error' ] ?? '',
'register' => $_SESSION['register_error' ] ?? ''
];
$activeForm = $_SESSION['active_form' ] ?? 'login';

session_unset();

function showError($error) {
return !empty($error) ? "<p class='error-message'>$error</p>" : '';

}

function isActiveForm($formName, $activeForm) {
return $formName === $activeForm ? 'active' : '';

}

?>





<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprachkursbuchung</title>
    <link rel="stylesheet" href="..\css\style.css">
</head>
<html>
<body style="background-color:rgb(176, 230, 199);">
  <header>
        <a href="..\index.html">
             <img src="../img/logo.png" alt="Logo" class="imglogo">
        </a>
        <nav>
            <ul>
                <li><a href="kursinfos.html">Kurse</a></li>
                <li><a href="ueberuns.html">Über uns</a></li>
                <li><a href="faq.html">FAQ</a></li>
                <li><a href="kontakt.html">Kontakt</a></li>
                <li><a href="impressum.html">Impressum</a></li>
                 <li></li><a href="login.html" class="anmeldenlink">Login</a></li>
            </ul>
        </nav>
       
  </header>
  <main>
<section class="login-section">

    <!-- LOGIN -->
    <div class="login-container <?= isActiveForm('login', $activeForm); ?>" id="login-form">
        <h2>Login</h2>
        <?= showError($errors['login']); ?>
        <form action="login_register.php" method="post">
            <label for="email">E-Mail</label>
            <input type="email" name="email" placeholder="beispiel@mail.de" required>

            <label for="passwort">Passwort</label>
            <input type="password" name="password" placeholder="••••••••" required>

            <button type="submit" name="login" class="login-btn">Login</button>
        </form>

        <p><a href="passwort-vergessen.html" class="forgot-link">Haben Sie das Passwort vergessen? Hier zurücksetzen.</a></p>
        <p><a href="gast.html" class="gast-link">Wollen Sie als Gast fortfahren?</a></p>
        <p> Haben Sie kein Konto?
            <a href="#" onclick="showForm('register-form')"> Registrieren</a>
        </p>
    </div>


    <!-- REGISTRIEREN -->
    <div class="login-container <?= isActiveForm('register', $activeForm); ?>" id="register-form">
        <h2>Registrieren</h2>
        <?=  showError($errors['register']); ?>
        <form action="login_register.php" method="post">
            <div class="register-row">
                <div class="register-col">
                    <label for="vorname">Vorname</label>
                    <input type="text" name="vorname" placeholder="Max" class="register-input">
                </div>
                <div class="register-col">
                    <label for="nachname">Nachname</label>
                    <input type="text" name="nachname" placeholder="Mustermann" class="register-input">
                </div>
            </div>

            <div class="register-row">
                <div class="register-col">
                    <label for="email">E-Mail</label>
                    <input type="email" name="email" placeholder="beispiel@email.de" class="register-input">
                </div>
                <div class="register-col">
                    <label for="passwort">Passwort</label>
                    <input type="password" name="password" placeholder="********" class="register-input">
                </div>
            </div>

            <select name="role" required>
                <option value="">---Select Role--</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit"name="register" class="register-btn">Registrieren</button>
        </form>

        <p><a href="..\index.html" class="register-gast-link">Als Gast fortfahren</a></p>
        <p> Haben Sie bereits Konto?
            <a href="#" onclick="showForm('login-form')"> Login</a>
        </p>
    </div>

</section>


   <aside>
    <p class="register-link">
        Neu hier?<br>
        <a href="#" onclick="showForm('register-form')">Jetzt registrieren</a>
    </p>
</aside>



  </main>
  <footer>
      <ul>
          <li><a href="datenschutzerklaerung.html">Datenschutzerklärung</a></li>
          <li><a href="agb.html">AGB</a></li>
          <li><a href="kontakt.html">Kontakt</a></li>
          <li><a href="impressum.html">Impressum</a></li>
      </ul>
  </footer>
  <script src="script.js"></script>
</body>
</html>

