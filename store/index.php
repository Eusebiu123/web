<?php
include "config.php";


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
                    // $sql="INSERT INTO videos(name,location) VALUES('".$name ."','".$target_file."')";
                    // mysqli_query($con,$sql);
                    $user=$_SESSION['username'];
                    $sql="INSERT INTO comenzi(username,nume_fisier,location) VALUES('".$user ."','".$name ."','".$target_file."')";
                    mysqli_query($con,$sql);
                    
    
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
    <style>
        body {
            padding: 0;
            margin: 0;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
        }
        
        .background {
            background: url('./background-img.jpg') rgba(0, 0, 0, 0.61);
            background-repeat: no-repeat;
            background-size: cover;
            background-blend-mode: darken;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: -1;
            filter: blur(3px);
            min-height: 800px;

        }
        
        h2 {
            font-size: 30px;
        }
        
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background: transparent;
            box-shadow: 0 0 15px rgb(255, 255, 255);
            border-radius: 15px;
            width: 500px;
            margin: 10vh auto;
        }
        
        form {
            padding: 10px;
            display: flex;
            flex-direction: column;
            width: 85%;
        }
        
        .form-item {
            display: flex;
            width: 90%;
            background: transparent;
            margin: 10px auto;
            align-items: center;
            border-radius: 15px;
            border-bottom: 1px solid rgb(82, 81, 81);
        }
        .form-item:hover {
            border: 1px solid rgb(82, 81, 81);;
        }
        input {
            font-size: 18px;
            width: 80%;
            height: 30px;
            outline: none;
            background: transparent;
            border: none;
            margin: auto;
            color: white;
        }
       
        
        span {
            margin: 5px;
            color: rgb(172, 172, 172);
            cursor: default;
            user-select: none;
            background: rgba(85, 81, 81, 0.637);
            padding: 5px;
            border-radius: 15px;
        }
        
        button[type="submit"] {
            width: 250px;
            font-size: 20px;
            margin: 10px auto;
            padding: 10px 16px;
            color: white;
            background: rgba(122, 123, 116, 0.72);
            border: none;
            text-align: center;
        }
        button[type="submit"]:hover {
            background: rgb(172, 134, 8);
        }
        p:first-of-type {
            font-size: 18px;
            margin: 0;
        }
        
        .options {
            display: flex;
            margin:  10px auto;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        button {
            padding: 5px 16px;
            font-size: 18px;
            margin: 5px 15px;
            width: 180px;
            color: white;
            background: transparent;
            cursor: pointer;
            transition: all 0.7s ease;
        }
        .fb:hover{
            background: rgb(5, 5, 73);
            border: none;
            box-shadow: 0 0 5px  rgb(5, 5, 73);
        }

        .gl:hover{
            background: rgb(73, 5, 5);
            border: none;
            box-shadow: 0 0 5px  rgb(73, 5, 5);

        }
        
        p {
            font-size: 18px;
            margin: 5px;
        }
        a{
            color: white;
        }
        a:hover{
            color: grey;
        }

        @media screen and (max-width:550px) {
            .container {
                width: 90%;
            }
            
        }
    </style>
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
    <!-- <div class="form-item">
                <span class="material-icons-outlined">
                    account_circle
                    </span>
                <input type="text" name="username"  id="text" placeholder="email">
            </div> -->
			<div class="form-item">
                
                <input type="text" name="email"  id="text" placeholder="nume_vehicul">
            </div>

            <div class="form-item">
    
                <input type="text" name="email" id="text" placeholder="piesa">

            </div>
            <div class="form-item">
              
                <input type="text" name="email" id="text" placeholder="data">

            </div>
            <div class="form-item">
               
                <input type="text" name="email" id="text" placeholder="ora">

            </div>
            <div class="form-item">
              
                <input type="text" name="email" id="text" placeholder="Detalii">

            </div>
			<div class="form-item">
                <input type="file" name="file" placeholder="Alege fisier video">

            </div>

            <button type="submit" name="submit" value="Upload"> Upload </button>
            <!-- <p>Already a member? <a href="login.php">Sign in</a></p> -->
        <!-- <input type="file" name="file"> -->
        <!-- <input type="submit" name="submit" value="Upload"> -->
    </form>
</body>
</html>