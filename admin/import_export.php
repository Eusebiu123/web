<?php


if(isset($_POST['iCSV'])){

    // $mysqli = new mysqli('localhost', 'root', '', 'registration');

    // var_dump($_FILES['file']);
    
    if(!empty($_FILES['file']['name'])){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            // ini_set('auto_detect_line_endings',TRUE);
            $csvFile = fopen ($_FILES['file']['tmp_name'],'r');
            // fgetcsv($csvFile,1000,",");
            while(($line = fgetcsv($csvFile))!== FALSE){
                // $nume = $line[0];
                // $marca = $line[1];
                // $piesa = $line[2];
                // $cantitatte = $line[3];

                $sql = "INSERT into stoc (nume_vehicul, marca, piesa, cantitate) 
                   values ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."')";
                   $result = mysqli_query($mysqli, $sql);

                //check if exists
                // $stmt = $mysqli->prepare("INSERT INTO stoc (nume_vehicul, marca, piesa, cantitate) VALUES (?,?,?,?)");
                // $stmt->bind_param('ssss', $nume, $marca, $piesa, $cantitate);
                // $stmt->execute();
                // $stmt->close();
                // $mysqli->close();
                sleep(1);
                header("Location: http://localhost/web/admin/stoc.php");

            }
            fclose($csvFile);
            // ini_set('auto_detect_line_endings',FALSE);
        }
    }
    // $csv->import($_FILES['file']['tmp_name'])
}

if(isset($_POST['iJSON'])){
//     copy($_FILES['jsonFile']['tmp_name'], 'jsonFiles/'.$_FILES['jsonFile']['name']);
//     $data = file_get_contents('jsonFiles/'.$_FILES['jsonFile']['name']);
//     $products = json_decode($data);
//     foreach ($products as $product) {
//         $stmt = $conn->prepare('insert into product(name, price, quantity) values(:name, :price, :quantity)');
//         $stmt->bindValue('name', $product->name);
//         $stmt->bindValue('price', $product->price);
//         $stmt->bindValue('quantity', $product->quantity);
//         $stmt->execute();
//     }
// }

    if(!empty($_FILES['file']['name'])){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            // ini_set('auto_detect_line_endings',TRUE);
            // $json = fopen ($_FILES['file']['tmp_name'],'r');
            $jsondata = file_get_contents($_FILES['file']['tmp_name']);
            $lines = json_decode($jsondata, true);

            // fgetcsv($csvFile,1000,",");
            foreach($lines as $line){

                $sql = "INSERT into stoc (nume_vehicul, marca, piesa, cantitate) 
                   values ('".$line['nume_vehicul']."','".$line['marca']."','".$line['piesa']."','".$line['cantitate']."')";
                   $result = mysqli_query($mysqli, $sql);

                //check if exists
                sleep(1);
                header("Location: http://localhost/web/admin/stoc.php");

            }
            // fclose($csvFile);
            // ini_set('auto_detect_line_endings',FALSE);
        }
    }

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

if(isset($_POST['eJSON'])){
    $sql = "SELECT * FROM stoc ";
    $result=mysqli_query($mysqli,$sql);

    $json_array = array ();

    while($rows=mysqli_fetch_assoc($result))
        {
            $json_array[]= $rows;
         }
    $json = json_encode($json_array);
    $fp = fopen('php://output','w');
    fwrite($fp, json_encode($json_array));
    fclose($fp);
    header('Content-Type: text/json');
    header('Content-Disposition: attachment; filename="stoc.json";');

    exit();
}

if(isset($_POST['ePDF'])){
    include_once('fpdf181/fpdf.php');
    // $pdf = new FPDF();
    // $pdf->AddPage();
 
    // $pdf->SetFont('Arial','B',12);
    $display_heading = array('id'=>'ID', 'nume_vehicul'=> 'Vehicul', 'marca'=> 'Marca','piesa'=> 'Piesa', 'cantitate'=>'Cantitate',);
 
    $result = mysqli_query($mysqli, "SELECT id, nume_vehicul, marca, piesa, cantitate FROM stoc") ;
    $header = mysqli_query($mysqli, "SHOW columns FROM stoc");
    
    $pdf = new FPDF();
    //header
    $pdf->AddPage();
    //foter page
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','B',12);
    foreach($header as $heading) {
    $pdf->Cell(40,12,$display_heading[$heading['Field']],1);
    }
    foreach($result as $row) {
    $pdf->Ln();
    foreach($row as $column)
    $pdf->Cell(40,12,$column,1);
    }
    $pdf->Output();

    }
    // $sql = "SELECT * FROM stoc ";
    // $result=mysqli_query($mysqli,$sql);

    // $pdf = new FPDF();
    // $pdf ->AddPage();
    // $pdf->AliasNbPages();
    // $pdf->SetFont('Arial','B', 12);
    
    // while($rows=mysqli_fetch_assoc($result))
    //     {
    //         $pdf->Cell(30,12,$rows,1);
    //      }
    // $json = json_encode($json_array);
    // $fp = fopen('php://output','w');
    // fwrite($fp, json_encode($json_array));
    // fclose($fp);
    // header('Content-Type: text/json');
    // header('Content-Disposition: attachment; filename="stoc.json";');

    // exit();
// }
?>