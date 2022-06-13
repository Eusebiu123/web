<?php
include('server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CyMaT - Autentificare</title>
</head>

<body>
    <div class="background"></div>
    <section class="container">
        <form class="form-login" method="post" action="login.php">
            <h2>Autentificare</h2>
            <?php include('errors.php'); ?>
            <div class="form-item">
                <input type="text" name="username" id="text" placeholder="Nume utilizator">
            </div>

            <div class="form-item">
                <input type="password" name="password" id="pass" placeholder="Parolă">
            </div>

            <button type="submit" name="login">AUTENTIFICARE</button>
            <p>Utilizator nou? <a href="register.php">Creează un cont</a></p>
        </form>
    </section>
</body>

</html>