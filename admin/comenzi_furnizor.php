<?php
include('../auth/server.php');
if (empty($_SESSION['username'])) {
    header('location: ../auth/login.php');
}
include('import_export.php');

if ($_SESSION['isadmin'] != 1) {
    header("Location: ../principal/principal-utilizator.php");
}

if (isset($_POST['confirm_delivery'])) {
    $delivery_id = $_POST['confirm_delivery'];

    $stmt = $mysqli->prepare("SELECT * FROM furnizor WHERE id = ?");
    $stmt->bind_param('s', $delivery_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    $stmt->close();

    $nume_vehicul = $result["nume_vehicul"];
    $marca = $result["marca"];
    $piesa = $result["piesa"];
    $cantitate_primita = $result["cantitate"];

    $stmt = $mysqli->prepare("SELECT cantitate FROM stoc WHERE (nume_vehicul, marca, piesa) = (?, ?, ?)");
    $stmt->bind_param('sss', $nume_vehicul, $marca, $piesa);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if (mysqli_num_rows($result) == 0) {
        $stmt = $mysqli->prepare("INSERT INTO stoc (nume_vehicul, marca, piesa, cantitate) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $nume_vehicul, $marca, $piesa, $cantitate_primita);
        $stmt->execute();
        $stmt->close();
    } else {
        $result = $result->fetch_assoc();
        $cantitate = $result["cantitate"] + $cantitate_primita;
        $stmt = $mysqli->prepare("UPDATE stoc SET cantitate = ? WHERE (nume_vehicul, marca, piesa) = (?, ?, ?)");
        $stmt->bind_param('ssss', $cantitate, $nume_vehicul, $marca, $piesa);
        $stmt->execute();
        $stmt->close();
    }

    $stmt = $mysqli->prepare("DELETE FROM furnizor WHERE id = ?");
    $stmt->bind_param('s', $delivery_id);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Comenzi Furnizor</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <table class="table-scheduling">
        <tr>
            <th colspan="6">
                <h2 style="text-align: center;">PIESE COMANDATE</h2>
            </th>
        </tr>

        <tr>
            <th>VEHICUL</th>
            <th>MARCA</th>
            <th>PIESA</th>
            <th>CANTITATE</th>
            <th>DECLARĂ PRIMITE</th>
            <tbody id="data"></tbody>
        </tr>
       
    </table>

    <div class="buttons">
        <form action="comenzi_furnizor.php" method="post" enctype="multipart/form-data">
            <input type="file" class="btn-submit" name="file" accept=".csv,.xls,.xlsx,.json">
            <input type="text" style="display:none" readonly name="page" value="furnizor">
            <input type="submit" class="btn-submit" name="iCSV" value="Import CSV">
            <input type="submit" class="btn-submit" name="iJSON" value="Import JSON">
            <input type="submit" class="btn-submit" name="eCSV" value="Export CSV">
            <input type="submit" class="btn-submit" name="eJSON" value="Export JSON">
            <input type="submit" class="btn-submit" name="ePDF" value="Export PDF">
        </form>
    </div>
    <a class="btn-submit" href="formular_furnizor.php">Comandă piese</a>
    <a class="btn-submit" href="stoc.php">Stoc curent</a>
    <a class="btn-submit" href="../principal/principal-admin.php">Pagina Principală</a>

    
    <script>
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "data_furnizor.php", true);
    ajax.send();
 
    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            console.log(data);
 
            var html = "";
            for(var a = 0; a < data.length; a++) {
                var nume_vehicul = data[a].nume_vehicul;
                var marca = data[a].marca;
                var piesa = data[a].piesa;
                var cantitate = data[a].cantitate;

 
                html += "<tr>";
                    html += "<td>" + nume_vehicul + "</td>";
                    html += "<td>" + marca + "</td>";
                    html += "<td>" + piesa + "</td>";
                    html += "<td>" + cantitate + "</td>";
                    html += "<td>" + "<button class='btn-submit' onclick=revealCell(" + data[a].id + ")>Declară primirea</button>"; 
                    html += "<td id='" + data[a].id + "' style='display:none'>Ești sigur?" + 
                    "<form action='comenzi_furnizor.php' method='post'>" +
                    "<button type='submit' class='btn-submit' name='confirm_delivery' value='" + data[a].id + "'>Da</button>" + 
                    "<button class='btn-submit red' onclick=hideCell(" + data[a].id + ")>Nu</button></form></td>";
                html += "</tr>";
            }
            document.getElementById("data").innerHTML += html;
        }
    };

    function revealCell(id) {
        document.getElementById(id).style = "display:table-cell";
    }

    function hideCell(id) {
        document.getElementById(id).style = "display:none";
    }
</script>

</body>

</html>
