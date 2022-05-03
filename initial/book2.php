<?php
include ('../auth/server.php');
$mysqli = new mysqli('localhost', 'root', '', 'registration');
if(isset($_GET['date'])){
    $date = $_GET['date'];
    $stmt = $mysqli->prepare("select * from bookings where date = ? ");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['timeslot'];
            }
            
            $stmt->close();
        }
    }
}

if(isset($_POST['submit'])){
    $nume_fisier=$_FILES['file']['name'];
    $target_dir="video/";
    $target_file= $target_dir.$nume_fisier;
    $extension= strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr=array("mp4","avi","3gp","mov","mpeg","jpg","png");
        if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
            $nume_vehicul=$mysqli->real_escape_string($_POST['nume_vehicul']);
            $marca=$mysqli->real_escape_string($_POST['marca']);
            $piesa=$mysqli->real_escape_string($_POST['piesa']);
            $detalii=$mysqli->real_escape_string($_POST['detalii']);
            $name = $_SESSION['username'];
            $timeslot = $_POST['timeslot'];
            $stmt = $mysqli->prepare("select * from bookings where date = ? AND timeslot=?");
            $stmt->bind_param('ss', $date,$timeslot);
            $bookings = array();
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows>0){
                    $msg = "<div class='alert alert-danger'>Already Booked</div>";
                }else{
                    $stmt = $mysqli->prepare("INSERT INTO bookings (name, date,timeslot,nume_vehicul,marca,piesa,detalii,nume_fisier,location) VALUES (?,?,?,?,?,?,?,?,?)");
                    $stmt->bind_param('sssssssss', $name, $date,$timeslot,$nume_vehicul,$marca,$piesa,$detalii,$nume_fisier,$target_file);
                    $stmt->execute();
                    $msg = "<div class='alert alert-success'>Booking Successfull</div>";
                    $bookings[]=$timeslot;
                    $stmt->close();
                    $mysqli->close();
                    sleep(1);
                    header("Location: http://localhost/principal/principal-utilizator.php");
                }
            }
        }   
}

$duration=30;
$cleanup=0;
$start="09:00";
$end="20:00";

function timeslots($duration,$cleanup,$start,$end){
            $start= new DateTime($start);
            $end= new DateTime($end);
            $interval= new DateInterval("PT".$duration."M");
            $cleanupInterval = new DateInterval("PT".$cleanup."M");
            $slots= array();

            for($intStart= $start;$intStart<$end;$intStart->add($interval)->add($cleanupInterval)){
                $endPeriod= clone $intStart;
                $endPeriod->add($interval);
                if($endPeriod>$end){
                    break;
                }

                $slots[]=$intStart->format("H:iA")."-". $endPeriod->format("H:iA");

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

    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
  </head>

  <body>
   
    <div class="container">
        <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); ?></h1><hr>
        <div class="row">
            <div class="col-md-12">
                <?php echo isset($msg)?$msg:"";?>
            </div>
            <?php $timeslots = timeslots($duration,$cleanup,$start,$end);
                foreach($timeslots as $ts){
            ?>
            <div class="col-md-2">
                <div class="form-group">
                    <?php if(in_array($ts,$bookings)){ ?>
                        <button class="btn btn-danger" ><?php echo $ts;?></button>
                    <?php }else{ ?>
                        <button class="btn btn-success book" data-timeslot="<?php echo $ts;?>"><?php echo $ts;?></button>
                    <?php } ?>
               
                </div>
              
            </div>
            <?php }?>
            
    </div>
    <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Booking: <span id="slot"></span></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" action="book.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Timeslot</label>
                        <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="">Nume Vehicul</label>
                        <input required type="text"  name="nume_vehicul"  class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="">Marca</label>
                        <input required type="text"  name="marca"  class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="">Piesa</label>
                        <input required type="text"  name="piesa"  class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="">Detalii</label>
                        <input required type="text"  name="detalii"  class="form-control">

                    </div>
                    <div class="form-group">
                    
                        <input  type="file"  name="file" placeholder="Alege fisier video" class="form-control">

                    </div>
                   
                   
                    <div class="form-group pull-right">
                        <button class="btn btn-primary" type="submit" action="book.php" name="submit" value="Upload">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
      </div>
      </div>
    </div>

  </div>
</div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
       $(".book").click(function(){
        //    var timeslot= $(this).attr('data-timeslot');
        //    $("#slot").html(timeslot);
        //    $("#timeslot").val(timeslot);
        //    $("#myModal").modal("show");
       }) 
    </script>
  </body>

</html>
