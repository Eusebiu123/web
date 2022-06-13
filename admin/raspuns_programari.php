<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Răspunsuri Programări</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <table class="table-scheduling">
        <tr>
            <th colspan="6">
                <h2>RĂSPUNSURI PROGRAMĂRI</h2>
            </th>
        </tr>

        <t>
            <th>NUME VEHICUL</th>
            <th>MARCA</th>
            <th>PIESA</th>
            <th>DATA</th>
            <th>ORA</th>
            <th>RASPUNS</th>
            <tbody id="data"></tbody>
        </t>
    </table>
    <a class="btn-submit" href="../principal/principal-utilizator.php">Pagina Principală</a>

    </script>
    <script>
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "data.php", true);
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
                var date = data[a].date;
                var timeslot = data[a].timeslot;
                var raspuns = data[a].raspuns;
 
                html += "<tr>";
                    html += "<td>" + nume_vehicul + "</td>";
                    html += "<td>" + marca + "</td>";
                    html += "<td>" + piesa + "</td>";
                    html += "<td>" + date + "</td>";
                    html += "<td>" + timeslot + "</td>";
                    html += "<td>" + raspuns + "</td>";
                html += "</tr>";
            }
            document.getElementById("data").innerHTML += html;
        }
    };
</script>

</body>

</html>