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
            <tbody id="data"></tbody>
        </t>

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