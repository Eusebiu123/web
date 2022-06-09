<?php
include('../auth/server.php');


$sql = "SELECT * FROM bookings";
#aici trebuie sa modificam interogarea...comenzile sa aiba data >=current date(gen sa afisam doar
#comenzile ce au data de azi sau din viitor:)))
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
            $sql = "UPDATE stoc SET cantitate = '$new' WHERE id = '$id'";
            $op = mysqli_query($mysqli, $sql);
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
            // {echo ('<li>Clientul ' . $inreg['name'] . 
            //     ' are marca ' . $inreg['marca'] . ' costa '. $pret. '</li>');
            $msj = 'Programare acceptata - pret estimativ: ' . $pret . ' lei';
            $sql = "UPDATE bookings SET raspuns = '$msj',acceptat='True' WHERE id = '$id'";
            $op = mysqli_query($mysqli, $sql);
        } else {
            $x = rand(2, 5);
            $msj = 'Ne pare rau, dar nu avem in stoc piesele necesare pentru reparatie, reveniti in ' . $x . ' saptamani';
            $sql = "UPDATE bookings SET raspuns = '$msj',acceptat='False' WHERE id = '$id'";
            $op = mysqli_query($mysqli, $sql);
            #aici trebuie modificat tabelul ala din calendar....el este ocupat in momentul de fata
            #de programarea curenta...pentru ca a fost respinsa trebuie facut update la calendar(data care e cu rosu trebuie facuta cu verde)
            #ne vom folosi de coloana acceptat pentru a modifica calendarul  
        }
    }
}

// fetchAll($mysqli);
// if(isset($_POST['btnSolve'])) {
//     global $mysqli;
//     fetchAll($mysqli);
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <table class="table-scheduling">
        <tr>
            <th colspan="6">
                <h2 style="text-align: center;">PROGRAMARI</h2>
            </th>
        </tr>

        <tr>
            <th>NUME UTILIZATOR</th>
            <th>NUME VEHICUL</th>
            <th>MARCA</th>
            <th>PIESA</th>
            <th>DATA</th>
            <th>ORA</th>
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
            </tr>
        <?php
        }
        ?>
    </table>
    <input type="submit" class="btn-submit" name="solveBtn" value="Rezolva Programarile" onClick="<?php fetchAll($mysqli); ?>">
    <div id="sideNav">
        <nav>
            <ul>
                <li><a href="../principal/principal-admin.php">HOME</a></li>
            </ul>
        </nav>
    </div>

    <div id="menuBtn">
        <img src="menu.png" id="menu">
    </div>

    <script>
        var menuBtn = document.getElementById("menuBtn")
        var sideNav = document.getElementById("sideNav")
        var menu = document.getElementById("menu")
        sideNav.style.right = "-250px";

        menuBtn.onclick = function() {
            if (sideNav.style.right == "-250px") {
                sideNav.style.right = "0";
                menu.src = "close.png";
            } else {
                sideNav.style.right = "-250px";
                menu.src = "menu.png";
            }
        }
        var scroll = new SmoothScroll('a[href*="#"]', {
            speed: 1000,
            speedAsDuration: true
        });
    </script>

</body>

</html>