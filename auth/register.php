<?php
include('server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Înregistrare</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="background"></div>
    <section class="container">
        <form class="form-login" method="post" action="register.php">
            <h2>Înregistrare</h2>
            <?php include('errors.php'); ?>

            <div class="form-item">
                <input type="text" name="username" id="text" minlength="5" placeholder="Nume utilizator">
            </div>

            <div class="form-item">
                <input type="email" name="email" id="text" placeholder="Adresă e-mail">
            </div>

            <div class="form-item">
                <input type="password" name="password_1" id="pass" minlength="8" placeholder="Parolă">
            </div>

            <div class="form-item">
                <input type="password" name="password_2" id="pass" minlength="8" placeholder="Confirmă parola">
            </div>
            <button type="submit" name="register">ÎNREGISTRARE</button>
            <p>Deja ai cont? <a href="login.php">Autentificare</a></p>
        </form>
    </section>
</body>

</html>
