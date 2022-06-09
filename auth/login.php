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
    <title>CyMaT - Login</title>
</head>

<body>
    <div class="background"></div>
    <section class="container">
        <form class="form-login" method="post" action="login.php">
            <h2>Login</h2>
            <?php include('errors.php'); ?>
            <div class="form-item">
                <input type="text" name="username" id="text" placeholder="username">
            </div>

            <div class="form-item">
                <input type="password" name="password" id="pass" placeholder="password">
            </div>

            <button type="submit" name="login"> LOGIN </button>
            <p>New User? <a href="register.php">Create an account</a></p>
        </form>
    </section>
</body>

</html>