<?php
include('../auth/server.php');


$sql = "SELECT * FROM bookings ";
$result=mysqli_query($mysqli,$sql);

function check($mysqli,$inreg){
    $pret = 0;
    $sql = 'SELECT * from stoc';
    $rez = mysqli_query($mysqli,$sql);
    while ($resurse = mysqli_fetch_assoc($rez)){
         if ($resurse['nume_vehicul'] == $inreg['nume_vehicul'] and
            $resurse['marca'] == $inreg['marca'] and
            $resurse['piesa'] == $inreg['piesa'] and
            $resurse['cantitate'] > 0)
                {$pret = $resurse['cantitate'] * 100;
                 $resurse['cantitate'] -= 1;
                 $new = $resurse['cantitate'];
                 $id = $resurse['id'];
                 $sql = "UPDATE stoc SET cantitate = '$new' WHERE id = '$id'";
                 $op = mysqli_query($mysqli,$sql);      
                }   
    }
    return $pret;
}

function fetchAll($mysqli){
    $data = [];

    $sql = 'SELECT * FROM bookings WHERE raspuns is NULL';
    $rez = mysqli_query($mysqli, $sql);
    while ($inreg = mysqli_fetch_assoc($rez)) {
        $pret = check($mysqli, $inreg);
        $id = $inreg['id'];
        if ($pret > 0){
            // {echo ('<li>Clientul ' . $inreg['name'] . 
            //     ' are marca ' . $inreg['marca'] . ' costa '. $pret. '</li>');
            $msj = 'Programare acceptata - pret estimativ: ' . $pret . ' lei'; 
            $sql = "UPDATE bookings SET raspuns = '$msj' WHERE id = '$id'";
            $op = mysqli_query($mysqli,$sql);      
            }
        else{
            $x = rand(2,5);
            $msj = 'Ne pare rau, dar nu avem in stoc piesele necesare pentru reparatie, reveniti in ' . $x . ' saptamani';
            $sql = "UPDATE bookings SET raspuns = '$msj' WHERE id = '$id'";
            $op = mysqli_query($mysqli,$sql);      
            }
    }
}
fetchAll($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ceva</title>
    <link rel = "stylesheet" href = "style.css">
</head>
<body>
        <table align="center" border="1px" style="width:1200px; line-height:60px;">
                <tr>
                    <th colspan="6"><h2 style="text-align: center;">PROGRAMARI</h2></th>
                </tr>

                <t>
                    <th>Username</th>
                    <th>Nume_Vehicul</th>
                    <th>MARCA</th>
                    <th>PIESA</th>
                    <th>DATA</th>
                    <th>ORA</th>
                </t>
                <?php
                while($rows=mysqli_fetch_assoc($result))
                {
                ?>
                    <tr>
                        <td><?php echo $rows['name']; ?></td>
                        <td><?php echo $rows['nume_vehicul']; ?></td>
                        <td><?php echo $rows['marca']; ?></td>
                        <td><?php echo $rows['piesa']; ?></td>
                        <td><?php echo $rows['date']; ?></td>
                        <td><?php echo $rows['timeslot']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>




    <div id="sideNav">
        <nav>
            <ul>
                <li><a href = "../principal/principal-admin.php">HOME</a></li>
            </ul>
        </nav>
    </div>
    
    <div id="menuBtn">
        <img src="menu.png" id="menu">
    </div>

    <script>
      var menuBtn =document.getElementById("menuBtn")
      var sideNav =document.getElementById("sideNav")
      var menu =document.getElementById("menu")
      sideNav.style.right = "-250px";
      
        menuBtn.onclick=function(){
            if(sideNav.style.right=="-250px"){
                sideNav.style.right = "0";
                menu.src="close.png";
            }
            else{
                sideNav.style.right = "-250px";
                menu.src="menu.png";
            }
        }
        var scroll = new SmoothScroll('a[href*="#"]', {
        speed: 1000,
        speedAsDuration: true
        });  
    </script>

</body>
</html>