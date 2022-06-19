<?php

include('../auth/server.php');

$mysqli = new mysqli('localhost', 'root', '', 'registration');

if (isset($_POST['response_form'])) {
    $id = $_POST['response_form'];
    $stmt = $mysqli->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $tip_piesa = $stmt->get_result();
    $tip_piesa = $tip_piesa->fetch_assoc();
    $stmt->close();

    $nume_vehicul = $tip_piesa["nume_vehicul"];
    $marca = $tip_piesa["marca"];
    $piesa = $tip_piesa["piesa"];

    $stmt = $mysqli->prepare("SELECT cantitate FROM stoc WHERE nume_vehicul = ? AND marca = ? AND piesa = ?");
    $stmt->bind_param('sss', $nume_vehicul, $marca, $piesa);
    $stmt->execute();
    $cantitate = $stmt->get_result();
    $cantitate = $cantitate->fetch_row();
    $cantitate = $cantitate[0];
    if ($cantitate == NULL) {
        $cantitate = 0;
    }
    $stmt->close();
    $mysqli->close();
}

if (isset($_POST['raspuns_trimis'])) {
    $id = $_POST['id_comanda'];
    $valoare_raspuns = $_POST['alegere_raspuns'];
    $text_raspuns = $_POST['raspuns'];

    $nume_vehicul = $_POST['nume_vehicul'];
    $marca = $_POST['marca'];
    $piesa = $_POST['piesa'];
    $cantitate = $_POST['cantitate'];

    $stmt = $mysqli->prepare("UPDATE bookings SET raspuns = ?, acceptat = ? WHERE id = ?");
    $stmt->bind_param('sss', $text_raspuns, $valoare_raspuns, $id);
    $stmt->execute();
    $stmt->close();

    if ($valoare_raspuns == "true") {
        $cantitate = $cantitate - 1;
        $stmt = $mysqli->prepare("UPDATE stoc SET cantitate = ? WHERE (nume_vehicul, marca, piesa) = (?, ?, ?)");
        $stmt->bind_param('ssss', $cantitate, $nume_vehicul, $marca, $piesa);
        $stmt->execute();
        $stmt->close();
    }
    $mysqli->close();
    sleep(1);
    header("Location: afisare_comenzi.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Formular programare</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
        <form class="form-submit" method="post" action="formular_programare.php">
            <h3>Detalii comandă</h3>
            <div>
                <label for="">Tip Vehicul:</label>
                <input style="display:none" type="text" name="id_comanda" value=<?php echo $id; ?>>
                <input readonly type="text" name="nume_vehicul" value=<?php echo $nume_vehicul; ?>>
            </div>

            <div>
                <label for="">Marca:</label>
                <input readonly type="text" name="marca" value=<?php echo $marca; ?>>
            </div>

            <div>
                <label for="">Piesa:</label>
                <input readonly type="text" name="piesa" value=<?php echo $piesa; ?>>
            </div>

            <div>
                <label for="">Număr în stoc:</label>
                <input readonly type="text" name="cantitate" value=<?php echo $cantitate; ?>>
            </div>

            <label for="">Răspuns:</label>

            <div>
                <div>
                    <input type="radio" required name="alegere_raspuns" value="true">
                    <label for="">Acceptă</label>
                    <input type="radio" required name="alegere_raspuns" value="false">
                    <label for="">Respinge</label>
                </div>
                <input required type="text" minlength="2" maxlength="99" name="raspuns">
            </div>

            <div>
                <button class="btn-submit" type="submit" name="raspuns_trimis" value="raspuns">Trimite răspuns</button>
                <a class="btn-submit" href="../admin/afisare_comenzi.php">Înapoi</a>
            </div>
        </form>
</body>

</html>