<?php

session_start();
if (!isset($_SESSION['email' ])) {
    header("Location: index.php");
    exit();
}
?>





<! DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="../css/stylesheet" href="style.css">
</head>

<body style="background:#fff;">

    <div class="boxAdminUser">
        <h1 class="h1welcome">Welcome, <span><?= $_SESSION['vorname']; ?></span></h1>
        <p>This is an <span class="welcomespan">user</span> page</p>
        <button onclick=window.location.href='logout.php"">Logout</button>
    </div>

</body>
</html>