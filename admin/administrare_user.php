<?php
include('../auth/server.php');

if (empty($_SESSION['username'])) {
    header('location: ../auth/login.php');
}

if ($_SESSION['isadmin'] != 1) {
    header("Location: ../principal/principal-utilizator.php");
}

$mysqli = new mysqli('localhost', 'root', '', 'registration');

if (isset($_POST['delete_user'])) {
    $deleted_id = $_POST['delete_user'];
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param('s', $deleted_id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['demote_user'])) {
    $demoted_id = $_POST['demote_user'];
    $stmt = $mysqli->prepare("UPDATE users SET isadmin = '0' WHERE id = ?");
    $stmt->bind_param('s', $demoted_id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['promote_user'])) {
    $promoted_id = $_POST['promote_user'];
    $stmt = $mysqli->prepare("UPDATE users SET isadmin = '1' WHERE id = ?");
    $stmt->bind_param('s', $promoted_id);
    $stmt->execute();
    $stmt->close();
}

$username = $_SESSION['username'];
$stmt = $mysqli->prepare("SELECT id, username, email, isadmin FROM users WHERE username != ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Administrare Utilizatori</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <table class="table-scheduling">
        <thead>
            <tr>
                <th colspan="5">
                    <h2 style="text-align: center;">UTILIZATORI</h2>
                </th>
            </tr>

            <tr>
                <th>NUME UTILIZATOR</th>
                <th>ADRESĂ EMAIL</th>
                <th>ADMINISTRATOR</th>
                <th>COMENZI</th>
            </tr>
        </thead>
        <tbody id="data"></tbody>
    </table>
    <div class="buttons">
        <form action="afisare_comenzi.php" method="post" enctype="multipart/form-data">
            <input type="file" class="btn-submit" name="file" accept=".csv,.xls,.xlsx,.json">
            <input type="text" style="display:none" readonly name="page" value="user">
            <input type="submit" class="btn-submit" name="iCSV" value="Import CSV">
            <input type="submit" class="btn-submit" name="iJSON" value="Import JSON">
            <input type="submit" class="btn-submit" name="eCSV" value="Export CSV">
            <input type="submit" class="btn-submit" name="eJSON" value="Export JSON">
            <input type="submit" class="btn-submit" name="ePDF" value="Export PDF">
        </form>
    </div>
    <a class="btn-submit" href="../principal/principal-admin.php">Pagina Principală</a>
</body>

<script>
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "data_user.php", true);
    ajax.send();

    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            console.log(data);

            var html = "";
            for (var a = 0; a < data.length; a++) {
                var id = data[a].id;
                var username = data[a].username;
                var email = data[a].email;
                var isadmin = data[a].isadmin;


                html += "<tr>";
                html += "<td>" + username + "</td>";
                html += "<td>" + email + "</td>";
                if (isadmin == 1) {
                    isadmin = "Da"
                } else {
                    isadmin = "Nu";
                }
                html += "<td>" + isadmin + "</td>";
                html += "<td>" + "<button class='btn-submit' onclick=revealDeletionCell(" + id + ")>Șterge</button>";

                if (isadmin == "Da") {
                    html += "<button class='btn-submit' onclick=revealDemotionCell(" + id + ")>Scoate drepturi admin.</button>" + "</td>"
                } else {
                    html += "<button class='btn-submit' onclick=revealPromotionCell(" + id + ")>Promovează admin.</button>" + "</td>"
                }
                html += "<td id='" + id + "' style='display:none'></td>";
                html += "</tr>";
            }
            document.getElementById("data").innerHTML += html;
        }
    };

    function revealCell(id) {
        var cell = document.getElementById(id);
        cell.innerHTML = "";

        var paragraph = document.createElement("p");
        paragraph.innerHTML = "Ești sigur?";

        var form = document.createElement("form");
        form.setAttribute("id", "hiddenForm" + id);
        form.setAttribute("action", "administrare_user.php");
        form.setAttribute("method", "post");
        form.innerHTML = "";

        var noButton = document.createElement("button");
        noButton.className = "btn-submit red";
        noButton.setAttribute("onclick", "hideCell(" + id + ")");
        noButton.innerHTML = "Nu";

        cell.appendChild(paragraph);
        cell.appendChild(form);
        cell.appendChild(noButton);

        cell.setAttribute("style", "display:table-cell");
    }

    function hideCell(id) {
        document.getElementById(id).style = "display:none";
    }

    function revealDeletionCell(id) {
        revealCell(id);
        var form = document.getElementById("hiddenForm" + id);

        var yesButton = document.createElement("button");
        yesButton.type = "submit";
        yesButton.className = "btn-submit";
        yesButton.name = "delete_user";
        yesButton.value = id;
        yesButton.innerHTML = "Șterge";

        form.appendChild(yesButton);
    }

    function revealDemotionCell(id) {
        revealCell(id);
        var form = document.getElementById("hiddenForm" + id);

        var yesButton = document.createElement("button");
        yesButton.type = "submit";
        yesButton.className = "btn-submit";
        yesButton.name = "demote_user";
        yesButton.value = id;
        yesButton.innerHTML = "Retrograd.";

        form.appendChild(yesButton);
    }

    function revealPromotionCell(id) {
        revealCell(id);
        var form = document.getElementById("hiddenForm" + id);

        var yesButton = document.createElement("button");
        yesButton.type = "submit";
        yesButton.className = "btn-submit";
        yesButton.name = "promote_user";
        yesButton.value = id;
        yesButton.innerHTML = "Promovează";

        form.appendChild(yesButton);
    }
</script>

</html>