<?php
include('../auth/server.php');

if(isset($_POST['submit'])){
    $maxsize= 1048576000;
    
    if(isset($_FILES['file']['name']) && $_FILES['file']['name'] !=''){
        $name=$_FILES['file']['name'];
        $target_dir="video/";
        $target_file= $target_dir.$name;

        $extension= strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $extensions_arr=array("mp4","avi","3gp","mov","mpeg","jpg","png");
        if(in_array($extension,$extensions_arr)){
            if($_FILES['file']['size']>=$maxsize){
                $_SESSION['message']="File too large. File must be less than 1000MB";
            }else{
                if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
                    $nume_vehicul=$mysqli->real_escape_string($_POST['nume_vehicul']);
                    $marca=$mysqli->real_escape_string($_POST['marca']);
                    $data=$mysqli->real_escape_string($_POST['data']);
                    $ora=$mysqli->real_escape_string($_POST['ora']);
                    $piesa=$mysqli->real_escape_string($_POST['piesa']);
                    $detalii=$mysqli->real_escape_string($_POST['detalii']);
                    $user=$_SESSION['username'];
                    $sql="INSERT INTO comenzi(username,nume_vehicul,marca,piesa,data,ora,detalii,nume_fisier,location) VALUES('".$user ."','".$nume_vehicul ."','".$marca ."','".$piesa ."','".$data ."','".$ora ."','".$detalii ."','".$name ."','".$target_file."')";
                    //TODO inserat in bd si data,ora,nume_vehicul,piesa
                    // $sql="INSERT INTO comenzi(username,nume_fisier,location) VALUES('".$user ."','".$name ."','".$target_file."')";
                    mysqli_query($mysqli,$sql);
                    
    
                    $_SESSION['message']="Upload successfully.";
                    
                }
                else{
                    header('location:config.php');
                }
            }
        }else{
            $_SESSION['message']="Invalid file extension.";
        }
    }else{
        $_SESSION['message']="Please select a file.";
    }
    header('location:index.php');
    exit;

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  
    <title></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <?php
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            header('location: ../principal/principal-utilizator.php');
        }
    ?>
    <div class="background"></div>
    <div class="container">
    <h2>Formular Programare</h2>
    <form method="post" action="index.php" enctype="multipart/form-data">
    
			<div class="form-item">
                
                <input type="text" name="nume_vehicul"  id="text" placeholder="nume_vehicul">
            </div>
            <div class="form-item">
                
                <input type="text" name="marca"  id="text" placeholder="marca">
            </div>

            <div class="form-item">
    
                <input type="text" name="piesa" id="text" placeholder="piesa">

            </div>
            <div class="form-item">
              
                <input type="text" name="data" id="text" placeholder="data">

            </div>
            <div class="form-item">
               
                <input type="text" name="ora" id="text" placeholder="ora">

            </div>
            <div class="form-item">
              
                <input type="text" name="detalii" id="text" placeholder="Detalii">

            </div>
			<div class="form-item">
                <input type="file" name="file" placeholder="Alege fisier video">

            </div>

            <button type="submit" action="index.php" name="submit" value="Upload"> Upload </button>
      
    </form>

    <div id="sideNav">
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
    </script>

</body>
</html>