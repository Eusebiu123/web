<?php
include('../auth/server.php');


$sql = "SELECT username,nume_autoturism,piesa,data,ora FROM comenzi order by data";
$fetchVideos=mysqli_query($mysqli,$sql);
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
while($row=mysqli_fetch_assoc($fetchVideos)){
    echo "<h3><center><color:red>Nume: ".$row["username"]. ", nume_autoturism : ". $row["nume_autoturism"] .", piesa: ". $row["piesa"] .".</center></h3>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Out - Generator</title>
    <link rel = "stylesheet" href = "style.css">
</head>
<body>

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