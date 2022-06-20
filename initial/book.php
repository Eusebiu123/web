<?php
include('../auth/server.php');

if ($_SESSION['isadmin'] == 1) {
    header("Location: ../principal/principal-admin.php");
}

$mysqli = new mysqli('localhost', 'root', '', 'registration');
if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $stmt = $mysqli->prepare("select * from bookings where date = ? ");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['timeslot'];
            }

            $stmt->close();
        }
    }
}
function eliberare_data_pt_programarile_respinse()
{
}

if (isset($_POST['submit'])) {
    $nume_fisier = $_FILES['file']['name'];
    $target_dir = "video/";
    $target_file = $target_dir . $nume_fisier;
    $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $extensions_arr = array("mp4", "avi", "3gp", "mov", "mpeg", "jpg", "png");
    $nume_vehicul = $mysqli->real_escape_string($_POST['nume_vehicul']);
    $marca = $mysqli->real_escape_string($_POST['marca']);
    $piesa = $mysqli->real_escape_string($_POST['piesa']);
    $detalii = $mysqli->real_escape_string($_POST['detalii']);
    $name = $_SESSION['username'];
    $date = $_POST['date'];
    $timeslot = $_POST['timeslot'];
    $stmt = $mysqli->prepare("select * from bookings where date = ? AND timeslot=?");
    $stmt->bind_param('ss', $date, $timeslot);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $stmt = $mysqli->prepare("INSERT INTO bookings (name,date,timeslot,nume_vehicul,marca,piesa,detalii,nume_fisier,location) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('sssssssss', $name, $date, $timeslot, $nume_vehicul, $marca, $piesa, $detalii, $nume_fisier, $target_file);
            $stmt->execute();
            $bookings[] = $timeslot;
            $stmt->close();
            $mysqli->close();
            sleep(1);
            header("Location: ../principal/principal-utilizator.php");
        }
    }
    // }   
}

$duration = 30;
$cleanup = 0;
$start = "09:00";
$end = "20:00";

function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }

        $slots[] = $intStart->format("H:iA") . "-" . $endPeriod->format("H:iA");
    }
    return $slots;
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Programare Service</title>
    <link rel="stylesheet" href="booking.css">
</head>

<body>
    <section class="background"></section>
    <div class="table-booking">
        <h1>Programare pentru data: <?php echo date('d/m/Y', strtotime($date)); ?></h1>
        <hr>
        <div class="row">
            <?php $timeslots = timeslots($duration, $cleanup, $start, $end);
            foreach ($timeslots as $ts) {
            ?>
                <td class="td-available">
                    <?php if (in_array($ts, $bookings)) { ?>
                        <button class="btn-booking-unavailable"><?php echo $ts; ?></button>
                    <?php } else { ?>
                        <button class="btn-booking" data-timeslot="<?php echo $ts; ?>" onclick="fillTimeslot(this)"><?php echo $ts; ?></button>
                    <?php } ?>
                </td>
            <?php } ?>

        </div>
    </div>

    <section class="form-booking">
        <form method="post" action="book.php" enctype="multipart/form-data">

            <div class="form-booking-item">
                <label for="">Data și ora alese</label>
                <input class="form-booking-input" readonly type="text" name="date" id="date" value=<?php echo $date; ?>>
                <input class="form-booking-input" required type="text" name="timeslot" id="timeslot" onkeydown="return false">
            </div>

            <div class="form-booking-item">
                <label for="">Nume Vehicul</label>
                <input class="form-booking-input" required type="text" name="nume_vehicul" id="test">
            </div>

            <div class="form-booking-item">
                <label for="">Marca</label>
                <input class="form-booking-input" required type="text" name="marca">
            </div>

            <div class="form-booking-item">
                <label for="">Piesa</label>
                <input class="form-booking-input" required type="text" name="piesa">
            </div>

            <div class="form-booking-item">
                <label for="">Detalii</label>
                <input class="form-booking-input" required type="text" name="detalii">
            </div>

            <div class="form-booking-item">
                <input class="form-booking-input" type="file" name="file" placeholder="Choose video file">
            </div>

            <div class="form-booking-item">
                <button class="btn-booking" type="submit" action="book.php" name="submit" value="Upload">Programare</button>
            </div>
        </form>
    </section>
    <section class="row" style="text-align:center">
        <a class="btn-booking" href="../principal/principal-utilizator.php">Înapoi</a>
    </section>
</body>

<script>
    function fillTimeslot(button) {
        console.log(button.innerHTML);
        document.getElementById("timeslot").value = button.innerHTML;
    }
</script>

</html>