<?php
include('../auth/server.php');
if (empty($_SESSION['username'])) {
    header('location: ../auth/login.php');
}

if ($_SESSION['isadmin'] != 1) {
    header("Location: ../principal/principal-utilizator.php");
}

$mysqli = new mysqli('localhost', 'root', '', 'registration');

if (isset($_POST['submit'])) {
    $vehicul = $mysqli->real_escape_string($_POST['type-veh']);
    $marca = $mysqli->real_escape_string($_POST['marca-f']);
    $piesa = $mysqli->real_escape_string($_POST['piesa-f']);
    $cantitate = $mysqli->real_escape_string($_POST['quantity']);

    $stmt = $mysqli->prepare("INSERT INTO furnizor (nume_vehicul, marca, piesa, cantitate) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $vehicul, $marca, $piesa, $cantitate);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
    sleep(1);
    header("Location: comenzi_furnizor.php");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Comandare Piese</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <div class="form-submit">
        <h3>Formular</h3>
        <form method="post" action="formular_furnizor.php">
            <div class="input-f">
                <label for="">Nume Service:</label>
                <input type="text" placeholder="Introduceti numele" required>
            </div>
            <div class="input-f">
                <label for="">Email:</label>
                <input type="email" placeholder="Introduceti email" required>
            </div>
            <div class="input-f">
                <label for="">Nr. telefon:</label>
                <input type="tel" placeholder="Introduceti numarul" required>
            </div>
            <label for="">Tip vehicul:</label>
            <div>
                <input type="radio" id="motocicleta" name="type-veh" value="motocicleta">
                <label for="motocicleta">Motocicletă</label>
                <input type="radio" id="bicicleta" name="type-veh" value="bicicleta">
                <label for="bicicleta">Bicicletă</label><br>
                <input type="radio" id="trotineta" name="type-veh" value="trotineta">
                <label for="trotineta">Trotinetă</label>
                <input type="radio" id="trotineta-el" name="type-veh" value="trotineta-el">
                <label for="trotineta-el">Trotinetă Electrică</label>
            </div>
            <div>
                <label for="marca-veh-f">Marca vehicul:</label>
                <select name="marca-f" id="marca-f">
                    <option value="Kawasaki">Kawasaki</option>
                    <option value="Honda">Honda</option>
                    <option value="Indian">Indian</option>
                    <option value="Suzuki">Suzuki</option>
                    <option value="Pegas">Pegas</option>
                    <option value="OEM">OEM</option>
                    <option value="Giant">Giant</option>
                    <option value="GT">GT</option>
                    <option value="Cube">Cube</option>
                    <option value="Zero">Zero</option>
                    <option value="Lime">Lime</option>
                    <option value="Razor">Razor</option>
                </select>
            </div>
            <div>
                <label for="piesa-veh-f">Piesa necesară:</label>
                <select name="piesa-f" id="piesa-f">
                    <option value="Roata">Roata</option>
                    <option value="Cadran">Cadran</option>
                    <option value="Ghidon">Ghidon</option>
                    <option value="Macara">Macara</option>
                    <option value="Maner">Maner</option>
                    <option value="Cauciuc">Cauciuc</option>>
                </select>
            </div>
            <div class="cantitate-detalii">
                <label for="quantity">Cantitate:</label>
                <input type="number" id="quantity" name="quantity" min="1" max="100" step="1" value="1">
            </div>
            <button class="btn-submit" type="submit" name="submit" value="comanda">Comandă</button>
        </form>
        <a class="btn-submit" href="../principal/principal-admin.php">Pagina Principală</a>
    </div>

</body>

</html>