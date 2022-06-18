<?php

if (isset($_POST['iCSV'])) {

    if (!empty($_FILES['file']['name'])) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            while (($line = fgetcsv($csvFile)) !== FALSE) {

                $sql = "INSERT into stoc (nume_vehicul, marca, piesa, cantitate) 
                   values ('" . $line[0] . "','" . $line[1] . "','" . $line[2] . "','" . $line[3] . "')";
                $result = mysqli_query($mysqli, $sql);

                sleep(1);
                header("Location: http://localhost/web/admin/stoc.php");
            }
            fclose($csvFile);
        }
    }
}

if (isset($_POST['iJSON'])) {

    if (!empty($_FILES['file']['name'])) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            $jsondata = file_get_contents($_FILES['file']['tmp_name']);
            $lines = json_decode($jsondata, true);
            foreach ($lines as $line) {

                $sql = "INSERT into stoc (nume_vehicul, marca, piesa, cantitate) 
                   values ('" . $line['nume_vehicul'] . "','" . $line['marca'] . "','" . $line['piesa'] . "','" . $line['cantitate'] . "')";
                $result = mysqli_query($mysqli, $sql);


                sleep(1);
                header("Location: http://localhost/web/admin/stoc.php");
            }
        }
    }
}

if (isset($_POST['eCSV'])) {
    $filename = "stoc_" . date('m-d') . ".csv";
    $delimitator = ",";

    $file = fopen("php://memory", "w");
    $fields = array('ID', 'Vehicul', 'Marca', 'Piesa', 'Cantitate');
    fputcsv($file, $fields, $delimitator);

    $sql = "SELECT * FROM stoc ";
    $result = mysqli_query($mysqli, $sql);
    while ($rows = mysqli_fetch_assoc($result)) {
        $line = array($rows['id'], $rows['nume_vehicul'], $rows['marca'], $rows['piesa'], $rows['cantitate']);
        fputcsv($file, $line, $delimitator);
    }

    fseek($file, 0);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    fpassthru($file);
    exit();
}

if (isset($_POST['eJSON'])) {
    $sql = "SELECT * FROM stoc ";
    $result = mysqli_query($mysqli, $sql);

    $json_array = array();

    while ($rows = mysqli_fetch_assoc($result)) {
        $json_array[] = $rows;
    }
    $json = json_encode($json_array);
    $fp = fopen('php://output', 'w');
    fwrite($fp, json_encode($json_array));
    fclose($fp);
    header('Content-Type: text/json');
    header('Content-Disposition: attachment; filename="stoc.json";');

    exit();
}

if (isset($_POST['ePDF'])) {
    include_once('fpdf181/fpdf.php');

    $page = $_POST['page'];

    $display_heading = array('nume_vehicul' => 'Vehicul', 'marca' => 'Marca', 'piesa' => 'Piesa');
    if ($page == 'stoc') {
        $display_update = array('id' => 'ID', 'cantitate' => 'Cantitate');
        $display_heading += $display_update;

        $stmt = $mysqli->prepare("SELECT id, nume_vehicul, marca, piesa, cantitate FROM stoc");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $stmt = $mysqli->prepare("SHOW columns FROM stoc");
        $stmt->execute();
        $header = $stmt->get_result();
        $stmt->close();

        $cells = 5;
        $font_size = 12;
    }
    elseif ($page == 'rezolvare') {
        $display_update = array('name' => 'Nume client', 'date' => 'Data', 'timeslot' => 'Ora');
        $display_heading += $display_update;

        $stmt = $mysqli->prepare("SELECT name, date, timeslot, nume_vehicul, marca, piesa FROM bookings WHERE raspuns is NULL");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $stmt = $mysqli->prepare("SHOW columns FROM bookings WHERE Field IN ('name', 'date', 'timeslot', 'nume_vehicul', 'marca', 'piesa')");
        $stmt->execute();
        $header = $stmt->get_result();
        $stmt->close();

        $cells = 6;
        $font_size = 9.5;
    }
    elseif ($page == 'programari') {
        $username = $_SESSION['username'];
        $display_update = array('date' => 'Data', 'timeslot' => 'Ora', 'acceptat' => 'Aprobare');
        $display_heading += $display_update;

        $stmt = $mysqli->prepare("SELECT date, timeslot, nume_vehicul, marca, piesa, acceptat FROM bookings WHERE name = ? AND raspuns IS NOT NULL");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $stmt = $mysqli->prepare("SHOW columns FROM bookings WHERE Field IN ('date', 'timeslot', 'nume_vehicul', 'marca', 'piesa', 'acceptat')");
        $stmt->execute();
        $header = $stmt->get_result();
        $stmt->close();

        $cells = 6;
        $font_size = 9.5;
    }

    $pdf = new FPDF();

    $pdf->AddPage();

    $pdf->AliasNbPages();
    $pdf->SetFont('Arial', 'B', $font_size);

    $page_width = 190;
    foreach ($header as $heading) {
        $pdf->Cell(intdiv($page_width, $cells), 12, $display_heading[$heading['Field']], 1, 0, 'C');
    }
    foreach ($result as $row) {
        $pdf->Ln();
        foreach ($row as $column)
            $pdf->Cell(intdiv($page_width, $cells), 12, $column, 1, 0, 'C');
    }
    $pdf->Output();
}
