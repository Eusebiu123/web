<?php
include('../auth/server.php');
include('import_export.php');

$sql = "SELECT * FROM stoc ";
$result=mysqli_query($mysqli,$sql);


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
    <table align="center" border="1px" style="width:700px; line-height:60px;">
        <tr>
            <th colspan="5"><h2 style="text-align: center;">Stoc Existent</h2></th>
        </tr>

        <t>
            <th>ID</th>
            <th>VEHICUL</th>
            <th>MARCA</th>
            <th>PIESA</th>
            <th>CANTITATE</th>
        </t>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {
        ?>
            <tr>
                <td><?php echo $rows['id']; ?></td>
                <td><?php echo $rows['nume_vehicul']; ?></td>
                <td><?php echo $rows['marca']; ?></td>
                <td><?php echo $rows['piesa']; ?></td>
                <td><?php echo $rows['cantitate']; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>

    <div class="buttons">
    <form method="post" action="stoc.php">
        <input type="file" name="file" accept=".csv,.xls,.xlsx">

        <input type="submit" name="iCSV"
                class="button" value="Import CSV" >
          
        <input type="submit" name="iJSON"
                class="button" value="Import JSON" >
        
        <input type="submit" name="eCSV"
                class="button" value="Export CSV" >
        
        <input type="submit" name="eJSON"
                class="button" value="Export JSON" >
        
        <input type="submit" name="ePDF"
                class="button" value="Export PDF" >
    </form> 
    </div>

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