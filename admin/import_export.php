<?php

$username = $_SESSION['username'];

if (isset($_POST['iCSV'])) {
    $page = $_POST['page'];
    if (!empty($_FILES['file']['name'])) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            while (($line = fgetcsv($csvFile)) !== FALSE) {
                if ($page == 'stoc') {
                    $stmt = $mysqli->prepare("SELECT cantitate FROM stoc WHERE (nume_vehicul, marca, piesa) = (?, ?, ?)");
                    $stmt->bind_param('sss', $line[0], $line[1], $line[2]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();
                    if (mysqli_num_rows($result) == 0) {
                        $stmt = $mysqli->prepare("INSERT INTO stoc (nume_vehicul, marca, piesa, cantitate) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param('ssss', $line[0], $line[1], $line[2], $line[3]);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        $result = $result->fetch_assoc();
                        $cantitate = $result['cantitate'] + $line[3];
                        $stmt = $mysqli->prepare("UPDATE stoc SET cantitate = ? WHERE (nume_vehicul, marca, piesa) = (?, ?, ?)");
                        $stmt->bind_param('ssss', $cantitate, $line[0], $line[1], $line[2]);
                        $stmt->execute();
                        $stmt->close();
                    }
                    header("Location: stoc.php");
                } elseif ($page == 'furnizor') {
                    $stmt = $mysqli->prepare("INSERT INTO furnizor (nume_vehicul, marca, piesa, cantitate) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param('ssss', $line[0], $line[1], $line[2], $line[3]);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: comenzi_furnizor.php");
                } elseif ($page == 'user') {
                    $stmt = $mysqli->prepare("INSERT INTO user (username, email, isadmin) VALUES (?, ?, '0')");
                    $stmt->bind_param('ss', $line[0], $line[1]);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: administrare_user.php");
                }
            }
        }
        fclose($csvFile);
    }
}

if (isset($_POST['iJSON'])) {
    $page = $_POST['page'];
    if (!empty($_FILES['file']['name'])) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            $jsondata = file_get_contents($_FILES['file']['tmp_name']);
            $lines = json_decode($jsondata, true);
            foreach ($lines as $line) {
                if ($page == 'stoc') {
                    $stmt = $mysqli->prepare("SELECT cantitate FROM stoc WHERE (nume_vehicul, marca, piesa) = (?, ?, ?)");
                    $stmt->bind_param('sss', $line['nume_vehicul'], $line['marca'], $line['piesa']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();
                    if (mysqli_num_rows($result) == 0) {
                        $stmt = $mysqli->prepare("INSERT INTO stoc (nume_vehicul, marca, piesa, cantitate) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param('ssss', $line['nume_vehicul'], $line['marca'], $line['piesa'], $line['cantitate']);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        $result = $result->fetch_assoc();
                        $cantitate = $result['cantitate'] + $line['cantitate'];
                        $stmt = $mysqli->prepare("UPDATE stoc SET cantitate = ? WHERE (nume_vehicul, marca, piesa) = (?, ?, ?)");
                        $stmt->bind_param('ssss', $cantitate, $line['nume_vehicul'], $line['marca'], $line['piesa']);
                        $stmt->execute();
                        $stmt->close();
                    }
                    header("Location: stoc.php");
                } elseif ($page == 'furnizor') {
                    $stmt = $mysqli->prepare("INSERT INTO furnizor (nume_vehicul, marca, piesa, cantitate) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param('ssss', $line['nume_vehicul'], $line['marca'], $line['piesa'], $line['cantitate']);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: comenzi_furnizor.php");
                } elseif ($page == 'user') {
                    $stmt = $mysqli->prepare("INSERT INTO user (username, email, isadmin) VALUES (?, ?, '0')");
                    $stmt->bind_param('ss', $line['username'], $line['email']);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: administrare_user.php");
                }
            }
        }
    }
}

if (isset($_POST['eCSV'])) {
    $page = $_POST['page'];
    $filename = $page . "_" . date('m-d') . ".csv";
    $delimitator = ",";

    $file = fopen("php://memory", "w");
    $fields = array('Vehicul', 'Marca', 'Piesa');
    if ($page == 'stoc') {
        array_splice($fields, 0, 0, 'ID');
        array_push($fields, 'Piesa', 'Cantitate');

        $stmt = $mysqli->prepare("SELECT nume_vehicul, marca, piesa, cantitate FROM stoc");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } elseif ($page == 'rezolvare') {
        $array_update = array('Nume', 'Data', 'Ora');
        array_splice($fields, 0, 0, $array_update);

        $stmt = $mysqli->prepare("SELECT name, date, timeslot, nume_vehicul, marca, piesa FROM bookings WHERE raspuns is NULL");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } elseif ($page == 'programari') {
        $array_update = array('Data', 'Ora');
        array_splice($fields, 0, 0, $array_update);
        array_push($fields, 'Aprobare', 'Raspuns');

        $stmt = $mysqli->prepare("SELECT date, timeslot, nume_vehicul, marca, piesa, acceptat, raspuns FROM bookings WHERE name = ? AND raspuns IS NOT NULL");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } elseif ($page == 'furnizor') {
        array_push($fields, 'Piesa', 'Cantitate');

        $stmt = $mysqli->prepare("SELECT nume_vehicul, marca, piesa, cantitate FROM furnizor");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } elseif ($page == 'user') {
        $fields = array('Utilizator, Email, Administrator');

        $stmt = $mysqli->prepare("SELECT username, email, isadmin FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    }

    while ($rows = $result->fetch_assoc()) {
        $line = array();
        if ($page == 'stoc') {
            $line = array($rows['nume_vehicul'], $rows['marca'], $rows['piesa'], $rows['cantitate']);
        } elseif ($page == 'rezolvare') {
            $line = array($rows['name'], $rows['date'], $rows['timeslot'], $rows['nume_vehicul'], $rows['marca'], $rows['piesa']);
        } elseif ($page == 'programari') {
            $array_update = array();
            $line = array($rows['date'], $rows['timeslot'], $rows['nume_vehicul'], $rows['marca'], $rows['piesa'], $rows['acceptat'], $rows['raspuns']);
        } elseif ($page == 'furnizor') {
            $line = array($rows['nume_vehicul'], $rows['marca'], $rows['piesa'], $rows['cantitate']);
        } elseif ($page == 'user') {
            $line = array($rows['username'], $rows['email'], $rows['isadmin']);
        }
        fputcsv($file, $line, $delimitator);
    }

    fseek($file, 0);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    fpassthru($file);
    exit();
}

if (isset($_POST['eJSON'])) {
    $page = $_POST['page'];
    if ($page == 'stoc') {
        $stmt = $mysqli->prepare("SELECT id, nume_vehicul, marca, piesa, cantitate FROM stoc");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } elseif ($page == 'rezolvare') {
        $stmt = $mysqli->prepare("SELECT name, date, timeslot, nume_vehicul, marca, piesa FROM bookings WHERE raspuns is NULL");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } elseif ($page == 'programari') {
        $stmt = $mysqli->prepare("SELECT date, timeslot, nume_vehicul, marca, piesa, acceptat, raspuns FROM bookings WHERE name = ? AND raspuns IS NOT NULL");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } elseif ($page == 'furnizor') {
        $stmt = $mysqli->prepare("SELECT nume_vehicul, marca, piesa, cantitate FROM furnizor");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } elseif ($page == 'user') {
        $stmt = $mysqli->prepare("SELECT username, email, isadmin FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    }

    $json_array = array();

    while ($rows = mysqli_fetch_assoc($result)) {
        $json_array[] = $rows;
    }
    $json = json_encode($json_array);
    $fp = fopen('php://output', 'w');
    fwrite($fp, json_encode($json_array));
    fclose($fp);
    header('Content-Type: text/json');
    header('Content-Disposition: attachment; filename="' . $page . '.json";');

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
    } elseif ($page == 'rezolvare') {
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
    } elseif ($page == 'programari') {
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
    } elseif ($page == 'furnizor') {
        $display_update = array('cantitate' => 'Cantitate');
        $display_heading += $display_update;

        $stmt = $mysqli->prepare("SELECT nume_vehicul, marca, piesa, cantitate FROM furnizor");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $stmt = $mysqli->prepare("SHOW columns FROM furnizor WHERE Field NOT IN ('id')");
        $stmt->execute();
        $header = $stmt->get_result();
        $stmt->close();

        $cells = 4;
        $font_size = 12;
    } elseif ($page == 'user') {
        $display_heading = array('username' => 'Nume Utilizator', 'email' => 'Adresa e-mail', 'isadmin' => 'Administrator');

        $stmt = $mysqli->prepare("SELECT username, email, isadmin FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $stmt = $mysqli->prepare("SHOW columns FROM users WHERE Field NOT IN ('id', 'password')");
        $stmt->execute();
        $header = $stmt->get_result();
        $stmt->close();

        $cells = 3;
        $font_size = 12;
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
