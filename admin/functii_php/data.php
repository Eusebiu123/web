<?php
include('../auth/server.php');

$sql = "SELECT * FROM booking where raspuns is not NULL";
$result =  mysqli_query($mysqli, $sql);

//storring in array;
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
//returning response in JSON format

echo json_encode($data);
