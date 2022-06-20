<?php
include('../auth/server.php');
$result = mysqli_query($mysqli, "SELECT * FROM furnizor");
 
$data = array();
while ($row = mysqli_fetch_object($result))
{
    array_push($data, $row);
}
 
echo json_encode($data);
exit();