<?php
include('../auth/server.php');
if (empty($_SESSION['username'])) {
    header('location: ../auth/login.php');
}
include('import_export.php');

$mysqli = new mysqli('localhost', 'root', '', 'registration');

$sql = "SELECT * FROM bookings WHERE raspuns is NULL ORDER BY date";

$result = mysqli_query($mysqli, $sql);

function check($mysqli, $inreg)
{
    $pret = 0;
    $sql = 'SELECT * from stoc';
    $rez = mysqli_query($mysqli, $sql);
    while ($resurse = mysqli_fetch_assoc($rez)) {

        if (
            strtolower($resurse['nume_vehicul']) == strtolower($inreg['nume_vehicul']) and
            strtolower($resurse['marca']) == strtolower($inreg['marca']) and
            strtolower($resurse['piesa']) == strtolower($inreg['piesa']) and
            $resurse['cantitate'] > 0
        ) {
            $pret = $resurse['cantitate'] * 100;
            $resurse['cantitate'] -= 1;
            $new = $resurse['cantitate'];
            $id = $resurse['id'];
            $stmt = $mysqli->prepare("UPDATE stoc SET cantitate = ? WHERE id = ?");
            $stmt->bind_param('ss', $new, $id);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
        }
    }
    return $pret;
}

function fetchAll($mysqli)
{
    $data = [];
    $sql = 'SELECT * FROM bookings WHERE raspuns is NULL';
    $rez = mysqli_query($mysqli, $sql);
    while ($inreg = mysqli_fetch_assoc($rez)) {
        $pret = check($mysqli, $inreg);
        $id = $inreg['id'];
        if ($pret > 0) {
            $msj = 'Programare acceptata - pret estimativ: ' . $pret . ' lei';
            $stmt = $mysqli->prepare("UPDATE bookings SET raspuns = ?, acceptat = 'True' WHERE id = ?");
            $stmt->bind_param('ss', $msj, $id);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
        } else {
            $x = rand(2, 5);
            $msj = 'Ne pare rau, dar nu avem in stoc piesele necesare pentru reparatie, reveniti in ' . $x . ' saptamani';
            $stmt = $mysqli->prepare("UPDATE bookings SET raspuns = ?, acceptat = 'False' WHERE id = ?");
            $stmt->bind_param('ss', $msj, $id);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Rezolvă Programările</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <table class="table-scheduling">
        <tr>
            <th colspan="7">
                <h2 style="text-align: center;">PROGRAMĂRI</h2>
            </th>
        </tr>

        <tr>
            <th>NUME UTILIZATOR</th>
            <th>NUME VEHICUL</th>
            <th>MARCA</th>
            <th>PIESA</th>
            <th>DATA</th>
            <th>ORA</th>
            <th>REZOLVARE</th>
        </tr>
        <?php
        while ($rows = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $rows['name']; ?></td>
                <td><?php echo $rows['nume_vehicul']; ?></td>
                <td><?php echo $rows['marca']; ?></td>
                <td><?php echo $rows['piesa']; ?></td>
                <td><?php echo $rows['date']; ?></td>
                <td><?php echo $rows['timeslot']; ?></td>
                <td>
                    <form action="formular_programare.php" method="post">
                        <button type="submit" class="btn-submit" name="response_form" value=<?php echo $rows['id']; ?>>Rezolvă</button>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <div class="buttons">
        <form action="afisare_comenzi.php" method="post" enctype="multipart/form-data">
            <input type="file" class="btn-submit" name="file" accept=".csv,.xls,.xlsx,.json">
            <input type="text" style="display:none" readonly name="page" value="rezolvare">
            <input type="submit" class="btn-submit" name="iCSV" value="Import CSV">
            <input type="submit" class="btn-submit" name="iJSON" value="Import JSON">
            <input type="submit" class="btn-submit" name="eCSV" value="Export CSV">
            <input type="submit" class="btn-submit" name="eJSON" value="Export JSON">
            <input type="submit" class="btn-submit" name="ePDF" value="Export PDF">
        </form>
    </div>
    <a class="btn-submit" href="../principal/principal-admin.php">Pagina Principală</a>

</body>

</html>