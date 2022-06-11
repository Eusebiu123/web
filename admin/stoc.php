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
            <th colspan="5">
                <h2 style="text-align: center;">Stoc Existent</h2>
            </th>
        </tr>

        <tr>
            <th>ID</th>
            <th>VEHICUL</th>
            <th>MARCA</th>
            <th>PIESA</th>
            <th>CANTITATE</th>
            <tbody id="data"></tbody>
        </tr>
       
    </table>

    <div class="buttons">
        <form action="stoc.php" method="post" enctype="multipart/form-data">
            <input type="file" class="btn-submit" name="file" accept=".csv,.xls,.xlsx,.json">
            <input type="submit" class="btn-submit" name="iCSV" value="Import CSV">
            <input type="submit" class="btn-submit" name="iJSON" value="Import JSON">
            <input type="submit" class="btn-submit" name="eCSV" value="Export CSV">
            <input type="submit" class="btn-submit" name="eJSON" value="Export JSON">
            <input type="submit" class="btn-submit" name="ePDF" value="Export PDF">
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
    <script>
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "datastoc.php", true);
    ajax.send();
 
    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            console.log(data);
 
            var html = "";
            for(var a = 0; a < data.length; a++) {
                var id = data[a].id;
                var nume_vehicul = data[a].nume_vehicul;
                var marca = data[a].marca;
                var piesa = data[a].piesa;
                var cantitate = data[a].cantitate;

 
                html += "<tr>";
                html += "<td>" + id + "</td>";
                    html += "<td>" + nume_vehicul + "</td>";
                    html += "<td>" + marca + "</td>";
                    html += "<td>" + piesa + "</td>";
                    html += "<td>" + cantitate + "</td>";
                html += "</tr>";
            }
            document.getElementById("data").innerHTML += html;
        }
    };
</script>

</body>

</html>
