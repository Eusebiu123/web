<?php

include('../auth/server.php');

if (empty($_SESSION['username'])) {
    header('location: ../auth/login.php');
}

if ($_SESSION['isadmin'] == 1) {
    header("Location: ../principal/principal-admin.php");
}

function build_calendar($month, $year)
{
    $mysqli = new mysqli('localhost', 'root', '', 'registration');
    $daysOfWeek = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    if ($dayOfWeek == 0) {
        $dayOfWeek = 6;
    } else {
        $dayOfWeek = $dayOfWeek - 1;
    }

    $datetoday = date('Y-m-d');



    $calendar = "<table class='table-booking'>";
    $calendar .= "<th colspan='7'><h2>$monthName $year</h2>";
    $calendar .= "<a class='btn-booking' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Luna Anterioară</a> ";
    $calendar .= " <a class='btn-booking' href='?month=" . date('m') . "&year=" . date('Y') . "'>Luna Curentă</a> ";
    $calendar .= "<a class='btn-booking' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Luna Următoare</a></th>";



    $calendar .= "<tr>";

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th  class='header'>$day</th>";
    }
    $currentDay = 1;

    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td class='empty'></td>";
        }
    }
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {

            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";

        $dayname = strtolower(date('l', strtotime($date)));
        $eventNum = 0;
        $today = $date == date('Y-m-d') ? "today" : "";
        if ($dayname == 'saturday' || $dayname == 'sunday') {
            $calendar .= "<td class='td-unavailable'><h4>$currentDay</h4> <button class='btn-unavailable'>Week-end</button>";
        } elseif ($date < date('Y-m-d')) {
            $calendar .= "<td class='td-unavailable'><h4>$currentDay</h4> <button class='btn-unavailable'>Zi terminată</button>";
        }
        else {
            $totalbookings = checkSlots($mysqli, $date);
            if ($totalbookings == 22) {
                $calendar .= "<td class='td-unavailable'><h4>$currentDay</h4> <button class='btn-unavailable'>Toate rezervate</button>";
            } else {

                $availableslots = 22 - $totalbookings;
                $calendar .= "<td class='td-available'><h4>$currentDay</h4> <a href='book.php?date=" . $date . "' class='btn-booking'>$availableslots rămase</a>";
            }
        }

        $calendar .= "</td>";
        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {

        $remainingDays = 7 - $dayOfWeek;
        for ($l = 0; $l < $remainingDays; $l++) {
            $calendar .= "<td class='empty'></td>";
        }
    }
    $calendar .= "</tr>";
    $calendar .= "</table>";

    echo $calendar;
}

function checkSlots($mysqli, $date)
{
    $stmt = $mysqli->prepare("select * from bookings where date= ? ");
    $stmt->bind_param('s', $date);
    $totalbookings = 0;
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalbookings++;
            }

            $stmt->close();
        }
    }
    return $totalbookings;
}


?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT - Programare Service</title>
    <link rel="stylesheet" href="booking.css">
</head>

<body>
    <section class="background"></section>
    <section class="container">
        <div class="row">
                <?php
                $dateComponents = getdate();
                if (isset($_GET['month']) && isset($_GET['year'])) {
                    $month = $_GET['month'];
                    $year = $_GET['year'];
                } else {
                    $month = $dateComponents['mon'];
                    $year = $dateComponents['year'];
                }
                echo build_calendar($month, $year);
                ?>
        </div>
    </section>
    <section class="row" style="text-align:center">
        <a class="btn-booking" href="../principal/principal-utilizator.php">Înapoi</a>
    </section>
</body>

</html>