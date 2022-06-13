<?php

function build_calendar($month, $year)
{
    $mysqli = new mysqli('localhost', 'root', '', 'registration');



    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

    // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

    // How many days does this month contain?
    $numberDays = date('t', $firstDayOfMonth);

    // Retrieve some information about the first day of the
    // month in question.
    $dateComponents = getdate($firstDayOfMonth);

    // What is the name of the month in question?
    $monthName = $dateComponents['month'];

    // What is the index value (0-6) of the first day of the
    // month in question.
    $dayOfWeek = $dateComponents['wday'];
    if ($dayOfWeek == 0) {
        $dayOfWeek = 6;
    } else {
        $dayOfWeek = $dayOfWeek - 1;
    }

    // Create the table tag opener and day headers

    $datetoday = date('Y-m-d');



    $calendar = "<table class='table-booking'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar .= "<a class='btn-booking' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Luna Anterioară</a> ";
    $calendar .= " <a class='btn-booking' href='?month=" . date('m') . "&year=" . date('Y') . "'>Luna Curentă</a> ";
    $calendar .= "<a class='btn-booking' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Luna Următoare</a></center><br>";



    $calendar .= "<tr>";

    // Create the calendar headers

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th  class='header'>$day</th>";
    }

    // Create the rest of the calendar

    // Initiate the day counter, starting with the 1st.

    $currentDay = 1;

    $calendar .= "</tr><tr>";

    // The variable $dayOfWeek is used to
    // ensure that the calendar
    // display consists of exactly 7 columns.

    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td class='empty'></td>";
        }
    }


    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        // Seventh column (Saturday) reached. Start a new row.

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
                $calendar .= "<td class='td-unavailable'><h4>$currentDay</h4> <a href='#' class='btn-unavailable'>Toate rezervate</a>";
            } else {

                $availableslots = 22 - $totalbookings;
                $calendar .= "<td class='td-available'><h4>$currentDay</h4> <a href='book.php?date=" . $date . "' class='btn-booking'>$availableslots rămase</a>";
            }
        }

        $calendar .= "</td>";
        // Increment counters

        $currentDay++;
        $dayOfWeek++;
    }

    // Complete the row of the last week in month, if necessary

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
            <div class="table-booking">
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
        </div>
    </section>
    <section class="row" style="text-align:center">
        <a class="btn-booking" href="../principal/principal-utilizator.php">Înapoi</a>
    </section>
</body>

</html>