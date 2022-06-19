<?php
include('../auth/server.php');
$name = $_SESSION['username'];
$stmt = $mysqli->prepare("SELECT * FROM bookings WHERE raspuns is not NULL AND name LIKE ? ORDER BY date");
$stmt->bind_param('s', $name);
$stmt->execute();
$result = $stmt->get_result();
 
$data = array();
while ($row = mysqli_fetch_object($result))
{
    array_push($data, $row);
}
 
echo json_encode($data);
exit();