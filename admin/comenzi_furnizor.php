<?php
include('../auth/server.php');

$mysqli = new mysqli('localhost', 'root', '', 'registration');

if (isset($_POST['submit'])) {
    $vehicul = $mysqli->real_escape_string($_POST['type-veh']);
    $marca = $mysqli->real_escape_string($_POST['marca-f']);
    $piesa = $mysqli->real_escape_string($_POST['piesa-f']);
    $cantitate = $mysqli->real_escape_string($_POST['quantity']);

    //  $sql = 'SELECT MAX(id) FROM stoc';
    //  $rez = mysqli_query($mysqli, $sql);
    //  $inreg = mysqli_fetch_assoc($rez);
    //  $id = $inreg['id'];
    //  $id += 1; 

    $stmt = $mysqli->prepare("INSERT INTO stoc (nume_vehicul, marca, piesa, cantitate) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $vehicul, $marca, $piesa, $cantitate);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
    sleep(1);
    header("Location: http://localhost/principal/principal-admin.php");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Admin</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <div class="container-f">
        <div class="title-f">Formular</div>
        <form method="post" action="comenzi_furnizor.php">
            <div class="company-f">
                <div class="input-f">
                    <span class="details-f">Nume Service</span>
                    <input type="text" placeholder="Introduceti numele" required>
                </div>
                <div class="input-f">
                    <span class="details-f">Email</span>
                    <input type="email" placeholder="Introduceti email" required>
                </div>
                <div class="input-f">
                    <span class="details-f">Nr. telefon</span>
                    <input type="tel" placeholder="Introduceti numarul" required>
                </div>
            </div>
            <div class="categorie-detalii-f">
                <span class="categorie-titlu-f">Tip vehicul</span>
                <div class="category-f">
                    <input type="radio" id="motocicleta" name="type-veh" value="motocicleta">
                    <label for="motocicleta">Motocicleta</label>
                    <input type="radio" id="bicicleta" name="type-veh" value="bicicleta">
                    <label for="bicicleta">Bicicleta</label><br>
                    <input type="radio" id="trotineta" name="type-veh" value="trotineta">
                    <label for="trotineta">Trotineta</label>
                    <input type="radio" id="trotineta-el" name="type-veh" value="trotineta-el">
                    <label for="trotineta-el">Trotineta Electrica</label>
                </div>
            </div>
            <div class="marca-detalii-f">
                <label for="marca-veh-f">Marca vehicul</label>
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
                </select><br>
            </div>
            <div class="piesa-detalii-f">
                <label for="piesa-veh-f">Piesa necesara</label>
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
            <div class="button-f">
                <input type="submit" name="submit" value="Submit">
            </div>
        </form>
    </div>


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