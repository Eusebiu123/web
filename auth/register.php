<?php
include('server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="background"></div>
    <section class="container">
        <form class="form-login" method="post" action="register.php">
            <h2>Register Form</h2>
            <?php include('errors.php'); ?>

            <div class="form-item">
                <input type="text" name="username" id="text" placeholder="username">
            </div>

            <div class="form-item">
                <input type="text" name="email" id="text" placeholder="email">
            </div>

            <div class="form-item">
                <input type="password" name="password_1" id="pass" placeholder="password">
            </div>

            <div class="form-item">
                <input type="password" name="password_2" id="pass" placeholder="Confirm password">
            </div>
            <button type="submit" name="register"> REGISTER </button>
            <p>Already a member? <a href="login.php">Sign in</a></p>
        </form>
    </section>
</body>

</html>