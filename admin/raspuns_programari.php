<?php
include('../auth/server.php');

$nume = $_SESSION['username'];
$sql = "SELECT * FROM bookings WHERE name = '$nume'";
$result = mysqli_query($mysqli, $sql);


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
                <h2 style="text-align: center;">RASPUNSURI PROGRAMARI</h2>
            </th>
        </tr>

        <t>
            <th>NUME VEHICUL</th>
            <th>MARCA</th>
            <th>PIESA</th>
            <th>DATA</th>
            <th>ORA</th>
            <th>RASPUNS</th>
        </t>
        <?php
        while ($inreg = mysqli_fetch_assoc($result)) {
            if ($inreg['raspuns'] != NULL) {

        ?>
                <tr>
                    <td><?php echo $inreg['nume_vehicul']; ?></td>
                    <td><?php echo $inreg['marca']; ?></td>
                    <td><?php echo $inreg['piesa']; ?></td>
                    <td><?php echo $inreg['date']; ?></td>
                    <td><?php echo $inreg['timeslot']; ?></td>
                    <td><?php echo $inreg['raspuns']; ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </table>

    <div id="sideNav">
        <nav>
            <ul>
                <li><a href="../principal/principal-utilizator.php">HOME</a></li>
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