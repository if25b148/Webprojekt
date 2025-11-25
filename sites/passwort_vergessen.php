<?php
session_start();
require_once 'config.php';

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $conn->query("UPDATE users SET password='$new_password' WHERE email='$email'");
        $_SESSION['success'] = "Passwort erfolgreich geändert! Sie können sich jetzt einloggen.";
        header("Location: login.php");
        exit();
    } else {
        $error = "Diese E-Mail ist nicht registriert.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Passwort zurücksetzen</title>
<link rel="stylesheet" href="../css/style.css"> <!-- optional -->
</head>
<body>
<h2>Neues Passwort setzen</h2>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($_SESSION['success'])) { echo "<p style='color:green;'>".$_SESSION['success']."</p>"; unset($_SESSION['success']); } ?>

<form method="post">
    <label>E-Mail:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Neues Passwort:</label><br>
    <input type="password" name="new_password" required><br><br>

    <button type="submit" name="reset">Passwort ändern</button>
</form>
</body>
</html>
