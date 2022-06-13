<?php

if(isset($_POST['iCSV'])){

    
    if(!empty($_FILES['file']['name'])){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
        
            $csvFile = fopen ($_FILES['file']['tmp_name'],'r');
           
            while(($line = fgetcsv($csvFile))!== FALSE){
              

                $sql = "INSERT into stoc (nume_vehicul, marca, piesa, cantitate) 
                   values ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."')";
                   $result = mysqli_query($mysqli, $sql);

                sleep(1);
                header("Location: http://localhost/web/admin/stoc.php");

            }
            fclose($csvFile);

        }
    }
 
}

if(isset($_POST['iJSON'])){

    if(!empty($_FILES['file']['name'])){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
        
            $jsondata = file_get_contents($_FILES['file']['tmp_name']);
            $lines = json_decode($jsondata, true);
            foreach($lines as $line){

                $sql = "INSERT into stoc (nume_vehicul, marca, piesa, cantitate) 
                   values ('".$line['nume_vehicul']."','".$line['marca']."','".$line['piesa']."','".$line['cantitate']."')";
                   $result = mysqli_query($mysqli, $sql);

        
                sleep(1);
                header("Location: http://localhost/web/admin/stoc.php");

            }
           
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

    $display_heading = array('id'=>'ID', 'nume_vehicul'=> 'Vehicul', 'marca'=> 'Marca','piesa'=> 'Piesa', 'cantitate'=>'Cantitate',);
 
    $result = mysqli_query($mysqli, "SELECT id, nume_vehicul, marca, piesa, cantitate FROM stoc") ;
    $header = mysqli_query($mysqli, "SHOW columns FROM stoc");
    
    $pdf = new FPDF();

    $pdf->AddPage();
  
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

?>