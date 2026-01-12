<?php
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        $error = 'Bitte füllen Sie alle Felder aus.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Bitte geben Sie eine gültige E-Mail-Adresse ein.';
    } else {
        $to = 'DEINE_EMAIL@DOMAIN.DE'; // <-- HIER DEINE E-MAIL EINTRAGEN
        $subject = 'Kontaktanfrage – Sprachkursbuchung';
        $headers = "From: $name <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8";

        $mailText = "Name: $name\nE-Mail: $email\n\nNachricht:\n$message";

        if (mail($to, $subject, $mailText, $headers)) {
            $success = 'Vielen Dank! Ihre Nachricht wurde erfolgreich gesendet.';
        } else {
            $error = 'Beim Senden der Nachricht ist ein Fehler aufgetreten.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kontakt – Sprachkursbuchung</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Dein eigenes CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body style="background-color: rgb(176, 230, 199);">

<header class="mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="../index.html">
            <img src="../img/logo.png" alt="Logo" class="imglogo">
        </a>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="kursinfos.php">Kurse</a></li>
                <li class="nav-item"><a class="nav-link" href="ueberuns.html">Über uns</a></li>
                <li class="nav-item"><a class="nav-link" href="faq.html">FAQ</a></li>
                <li class="nav-item"><a class="nav-link active" href="kontakt.php">Kontakt</a></li>
                <li class="nav-item"><a class="nav-link" href="impressum.html">Impressum</a></li>
                <li class="nav-item"><a class="nav-link anmeldenlink" href="login.php">Login</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <h1 class="mb-4 text-center">Kontakt</h1>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" class="card p-4 shadow-sm">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">E-Mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nachricht</label>
                    <textarea name="message" rows="5" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Nachricht senden
                </button>
            </form>

        </div>
    </div>
</main>

<footer class="mt-5">
    <ul class="nav justify-content-center">
        <li class="nav-item"><a class="nav-link" href="datenschutzerklaerung.html">Datenschutzerklärung</a></li>
        <li class="nav-item"><a class="nav-link" href="agb.html">AGB</a></li>
        <li class="nav-item"><a class="nav-link" href="kontakt.php">Kontakt</a></li>
        <li class="nav-item"><a class="nav-link" href="impressum.html">Impressum</a></li>
    </ul>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
