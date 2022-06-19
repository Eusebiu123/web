<?php
include('../auth/server.php');

if (empty($_SESSION['username'])) {
    header('location: ../auth/login.php');
}

$mysqli = new mysqli('localhost', 'root', '', 'registration');

if (isset($_POST['delete_user'])) {
    $deleted_id = $_POST['delete_user'];
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param('s', $deleted_id);
    $stmt->execute();
    $result = $stmt->get_result();
}

$username = $_SESSION['username'];
$stmt = $mysqli->prepare("SELECT id, username, email, isadmin FROM users WHERE username != ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
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
        <tr>
            <th colspan="5">
                <h2 style="text-align: center;">UTILIZATORI</h2>
            </th>
        </tr>

        <tr>
            <th>NUME UTILIZATOR</th>
            <th>ADRESĂ EMAIL</th>
            <th>ADMINISTRATOR</th>
            <th>ȘTERGE</th>
            <th id="hidden_column" style="display:none">CONFIRMARE</th>
        </tr>
        <?php
        while ($rows = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $rows['username']; ?></td>
                <td><?php echo $rows['email']; ?></td>
                <td><?php if ($rows['isadmin'] == 1) echo "Da";
                    else echo "Nu"; ?></td>
                <td>
                    <button class="btn-submit" onclick=revealCell(<?php echo $rows['id'] ?>)>Șterge</button>
                </td>
                <td id=<?php echo $rows['id'] ?> style="display:none">
                    <p>Ești sigur?</p>
                    <form action="administrare_user.php" method="post">
                        <button type="submit" class="btn-submit" name="delete_user" value=<?php echo $rows['id']; ?>>Da</button>
                        <button class="btn-submit red" onclick=hideCell(<?php echo $rows['id'] ?>)>Nu</button>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <a class="btn-submit" href="../principal/principal-admin.php">Pagina Principală</a>
</body>

<script>
    function revealCell(id) {
        document.getElementById(id).style = "display:table-cell";
        document.getElementById("hidden_column").style = "display:table-cell";
    }

    function hideCell(id) {
        document.getElementById(id).style = "display:none";
        document.getElementById("hidden_column").style = "display:none";
    }
</script>

</html>