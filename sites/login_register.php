<?php
session_start();
require_once 'config.php';      //DB-Verbindung laden

$returnUrl = $_POST['return_url'] ?? 'user_page.php';       //Zielseite nach Login/Register

if (isset($_POST['register'])) {        //Registrierungsformular abgeschickt
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);        //Passwort hashen
    $role = $_POST['role'];         //Benutzerrolle

    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");        //E-Mail prüfen
    if ($checkEmail->num_rows > 0) {            //E-Mail existiert bereits
        $_SESSION['register_error'] = 'Email ist bereits registriert!';         //Fehlermeldung
        $_SESSION['active_form'] = 'register';        //Registrierungsformular aktiv
        header("Location: login.php");                //Zurück zur Login-Seite 
        exit();
    } else {
        $conn->query("INSERT INTO users (vorname, nachname, email, password, role) VALUES ('$vorname', '$nachname', '$email', '$password', '$role')");  //User anlegen
        $_SESSION['user_id'] = $conn->insert_id;        //User-ID speichern
        $_SESSION['vorname'] = $vorname;                //Vorname speichern
        $_SESSION['nachname'] = $nachname;              //Nachname speichern
        $_SESSION['email'] = $email;                    //E-Mail speichern
        $_SESSION['role'] = strtolower($role);          //Rolle speichern

        header("Location: " . $returnUrl);              //Weiterleitung nach Registrierung
        exit();
    }
}

if (isset($_POST['login'])) {           //Loginformular abgeschickt
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");       //User laden
    if ($result->num_rows > 0) {            //User gefunden
        $user = $result->fetch_assoc();     //User-Daten holen
        if (password_verify($password, $user['password'])) {        //Passwort prüfen
            $_SESSION['user_id'] = $user['id'];                     //User-ID speichern
            $_SESSION['vorname'] = $user['vorname'];                //Vorname speichern
            $_SESSION['nachname'] = $user['nachname'];              //Nachname speichern
            $_SESSION['email'] = $user['email'];                    //E-Mail speichern
            $_SESSION['role'] = strtolower($user['role']);          //Rolle speichern

            if (!empty($returnUrl)) {                               //Rücksprung vorhanden?
                header("Location: " . $returnUrl);                  //Zurück zur Zielseite
            } elseif ($user['role'] === 'admin') {                  //Admin?
                header("Location: admin_page.php");                 //Admin-Seite
            } else {
                header("Location: user_page.php");                  //User-Seite
            }
            exit();
        }
    }

    $_SESSION['login_error'] = 'Falsche E-Mail oder Passwort';              //Fehlermeldung
    $_SESSION['active_form'] = 'login';                                     //Loginformular aktiv
    header("Location: login.php?return_url=" . urlencode($returnUrl));      //Zurück zum Login
    exit();
}
