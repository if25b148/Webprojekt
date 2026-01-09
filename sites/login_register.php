<?php
session_start();
require_once 'config.php';

$returnUrl = $_POST['return_url'] ?? 'user_page.php';

if (isset($_POST['register'])) {
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email ist bereits registriert!';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    } else {
        $conn->query("INSERT INTO users (vorname, nachname, email, password, role) VALUES ('$vorname', '$nachname', '$email', '$password', '$role')");
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['vorname'] = $vorname;
        $_SESSION['nachname'] = $nachname;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = strtolower($role);

        header("Location: " . $returnUrl);
        exit();
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['vorname'] = $user['vorname'];
            $_SESSION['nachname'] = $user['nachname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = strtolower($user['role']);

            if (!empty($returnUrl)) {
                header("Location: " . $returnUrl);
            } elseif ($user['role'] === 'admin') {
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }
            exit();
        }
    }

    $_SESSION['login_error'] = 'Falsche E-Mail oder Passwort';
    $_SESSION['active_form'] = 'login';
    header("Location: login.php?return_url=" . urlencode($returnUrl));
    exit();
}
