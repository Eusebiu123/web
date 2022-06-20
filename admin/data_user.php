<?php
include('../auth/server.php');
$stmt = $mysqli->prepare("SELECT id, username, email, isadmin FROM users WHERE username NOT IN (?)");
$username = $_SESSION['username'];
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
 
$data = array();
while ($row = mysqli_fetch_object($result))
{
    array_push($data, $row);
}
 
echo json_encode($data);
exit();