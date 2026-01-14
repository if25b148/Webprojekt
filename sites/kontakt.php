
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kontakt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="min-vh-100 fs-5" style="background-color: rgb(176, 230, 199);">

<header>
<nav class="navbar navbar-expand-lg" style="background-color: rgb(176, 230, 199);">
  <div class="container">

    
    <a  href="../index.html">
      <img src="../img/logo.png" alt="Logo" width="80">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">

      <ul class="navbar-nav gap-5 ms-auto">
        <li class="nav-item"><a class="nav-link" href="kursinfos.php">Kurse</a></li>
        <li class="nav-item"><a class="nav-link" href="ueberuns.html">Über uns</a></li>
        <li class="nav-item"><a class="nav-link" href="faq.html">FAQ</a></li>
        <li class="nav-item"><a class="nav-link active" href="kontakt.php">Kontakt</a></li>
        <li class="nav-item"><a class="nav-link" href="impressum.html">Impressum</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
      </ul>

    </div>
  </div>
</nav>

</header>


<main class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">

        <h1 class="mb-4 text-center">Kontakt</h1>

        <!-- Kontaktformular mit mailto -->
        <form action="mailto:if25b079@technikum-wien.at" method="post" enctype="text/plain" class="card p-4 shadow-sm">

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

            <button type="submit" class="btn btn-success w-100">Nachricht senden</button>
        </form>

      </div>
    </div>
</main>

<footer class="mt-4 py-3" >
    <div class="container">
        <ul class="nav justify-content-around">

            <li class="nav-item">
                <a class="nav-link text-dark" href="datenschutzerklaerung.html">
                    Datenschutzerklärung
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="agb.html">
                    AGB
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="kontakt.php">
                    Kontakt
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="impressum.html">
                    Impressum
                </a>
            </li>
        </ul>
    </div>
</footer>



</>
</html>
