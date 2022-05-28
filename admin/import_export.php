<?php


if(isset($_POST['iCSV'])){

    $mysqli = new mysqli('localhost', 'root', '', 'registration');

    // var_dump($_FILES['file']);
    
    if(!empty($_FILES['file']['name'])){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            $csvFile = fopen ($_FILES['file']['tmp_name'],'r');
            fgetcsv($csvFile);
            while(($line = fgetcsv($csvFile))!== FALSE){
                $nume = $line[0];
                $marca = $line[1];
                $piesa = $line[2];
                $cantitatte = $line[3];


                //check if exists
                $stmt = $mysqli->prepare("INSERT INTO stoc (nume_vehicul, marca, piesa, cantitate) VALUES (?,?,?,?)");
                $stmt->bind_param('ssss', $nume, $marca, $piesa, $cantitate);
                $stmt->execute();
                $stmt->close();
                $mysqli->close();
                sleep(1);
                header("Location: http://localhost/web/principal/stoc.php");

            }
            fclose($csvFile);
        }
    }
    // $csv->import($_FILES['file']['tmp_name'])
}
    
if(isset($_POST['eCSV'])){
    $filename = "stoc_". date('m-d') . ".csv";
    $delimitator = ",";

    $file = fopen("php://memory","w");
    $fields = array('ID','Vehicul','Marca','Piesa','Cantitate');
    fputcsv($file, $fields, $delimitator);

    $sql = "SELECT * FROM stoc ";
    $result=mysqli_query($mysqli,$sql);
    while($rows=mysqli_fetch_assoc($result))
        {
            $line = array($rows['id'],$rows['nume_vehicul'],$rows['marca'],$rows['piesa'],$rows['cantitate']);
            fputcsv($file, $line, $delimitator);
         }
    
    fseek($file, 0);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    fpassthru($file);
    exit();
}
// function importCSV($file){
//     $file = fopen($file, 'r');
//     while ($row = fgetcsv($file)){

//     }
// }


?>