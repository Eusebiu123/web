<?php

function build_calendar($month, $year) {
    $mysqli = new mysqli('localhost', 'root', '', 'registration');
    
    
    
     // Create array containing abbreviations of days of week.
     $daysOfWeek = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');

     // What is the first day of the month in question?
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
     $numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
     $dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
     $monthName = $dateComponents['month'];

     // What is the index value (0-6) of the first day of the
     // month in question.
     $dayOfWeek = $dateComponents['wday'];
     if($dayOfWeek==0){
        $dayOfWeek=6;
     }else{
        $dayOfWeek=$dayOfWeek-1;
     }

     // Create the table tag opener and day headers
     
    $datetoday = date('Y-m-d');
    
    
    
    $calendar = "<table class='table-booking'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar.= "<a class='btn-booking' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Previous Month</a> ";
    
    $calendar.= " <a class='btn-booking' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a> ";
    
    $calendar.= "<a class='btn-booking' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Next Month</a></center><br>";
    
    
        
      $calendar .= "<tr>";

     // Create the calendar headers

     foreach($daysOfWeek as $day) {
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
            for($k=0;$k<$dayOfWeek;$k++){
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
            $today = $date==date('Y-m-d')? "today" : "";
            if($dayname=='saturday' || $dayname=='sunday'){
                $calendar.="<td class='td-unavailable'><h4>$currentDay</h4> <button class='btn-unavailable'>Holiday</button>";
            }elseif($date<date('Y-m-d')){
                $calendar.="<td class='td-unavailable'><h4>$currentDay</h4> <button class='btn-unavailable'>Day passed</button>";
         }
        //  }elseif(in_array($date, $bookings)){
        //      $calendar.="<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>Already Booked</button>";
        //  }
        else{
            $totalbookings=checkSlots($mysqli,$date);
            if($totalbookings==22){
                $calendar.="<td class='td-unavailable'><h4>$currentDay</h4> <a href='#' class='btn-unavailable'>All Booked</a>";
            }else{

                $availableslots=22-$totalbookings;
                $calendar.="<td class='td-available'><h4>$currentDay</h4> <a href='book.php?date=".$date."' class='btn-booking'>$availableslots slots left</a>";
            }
           
         }
            
          $calendar .="</td>";
          // Increment counters
 
          $currentDay++;
          $dayOfWeek++;

        }

     // Complete the row of the last week in month, if necessary

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
            for($l=0;$l<$remainingDays;$l++){
                $calendar .= "<td class='empty'></td>"; 

            }

     }
     $calendar .= "</tr>";
     $calendar .= "</table>";

     echo $calendar;

}

function checkSlots($mysqli,$date){
    $stmt = $mysqli->prepare("select * from bookings where date= ? ");
    $stmt->bind_param('s', $date);
    $totalbookings =0;
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
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
    <title>CyMaT - Book Service Meeting</title>
    <link rel="stylesheet" href="booking.css">
</head>

<body>
<!-- <div id="sideNav">
        <nav>
            <ul>
                <li><a href = "../principal/principal-utilizator.php">HOME</a></li>
            </ul>
        </nav>
    </div>
    
    <div id="menuBtn">
        <img src="../admin/menu.png" id="menu">
    </div>

    <script>
      var menuBtn =document.getElementById("menuBtn")
      var sideNav =document.getElementById("sideNav")
      var menu =document.getElementById("menu")
      sideNav.style.right = "-250px";
      
        menuBtn.onclick=function(){
            if(sideNav.style.right=="-250px"){
                sideNav.style.right = "0";
                menu.src="../admin/close.png";
            }
            else{
                sideNav.style.right = "-250px";
                menu.src="../admin/menu.png";
            }
        }
        var scroll = new SmoothScroll('a[href*="#"]', {
        speed: 1000,
        speedAsDuration: true
        });  
    </script> -->
    <section class="background"></section>
    <section class="container">
        <div class="row">
            <div class="table-booking">
                <?php
                     $dateComponents = getdate();
                     if(isset($_GET['month']) && isset($_GET['year'])){
                         $month = $_GET['month']; 			     
                         $year = $_GET['year'];
                     }else{
                         $month = $dateComponents['mon']; 			     
                         $year = $dateComponents['year'];
                     }
                    echo build_calendar($month,$year);
                ?>
            </div>
        </div>
    </section>
    
</body>

</html>
