<?php
    include('../auth/server.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <title></title>
</head>
<body>
    <div>
        <?php
            $fetchVideos=mysqli_query($mysqli,"SELECT * FROM comenzi ORDER BY id DESC");
            while($row=mysqli_fetch_assoc($fetchVideos)){
                $name=$row['nume_fisier'];
                $location=$row['location'];

                echo "<div style='float: left; margin-right:5px;'>
                <video src='".$location."' controls width='320px'
                height='320px'></video><br>
                <span>".$name."</span>
                </div>";
                
                
            }
        ?>


    </div>
</body>
</html>