<?php
include('../auth/server.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar programari</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="background">
        <div class="calendar">
            <div class="month">
                <p>Alegeti data si ora programarii:</p>
            </div>
            <div class="month">
                <strong>MAI</strong>
                <strong>2022</strong>
            </div>
            <table>
                <tr>
                    <th>Dum</th>
                    <th>Lun</th>
                    <th>Mar</th>
                    <th>Mie</th>
                    <th>Joi</th>
                    <th>Vin</th>
                    <th>Sam</th>
                </tr>
                <tr>
                    <td class="available">1</td>
                    <td class="available">2</td>
                    <td class="available">3</td>
                    <td class="available">4</td>
                    <td class="available">5</td>
                    <td class="not-available">6</td>
                    <td class="available">7</td>
                </tr>
                <tr>
                    <td class="available">8</td>
                    <td class="available">9</td>
                    <td class="available">10</td>
                    <td class="not-available">11</td>
                    <td class="available">12</td>
                    <td class="available">13</td>
                    <td class="available">14</td>
                </tr>
                <tr>
                    <td class="available">15</td>
                    <td class="not-available">16</td>
                    <td class="available">17</td>
                    <td class="available">18</td>
                    <td class="available">19</td>
                    <td class="not-available">20</td>
                    <td class="available">21</td>
                </tr>
                <tr>
                    <td class="available">22</td>
                    <td class="available">23</td>
                    <td class="available">24</td>
                    <td class="available">25</td>
                    <td class="not-available">26</td>
                    <td class="available">27</td>
                    <td class="available">28</td>
                </tr>
                <tr>
                    <td class="available">29</td>
                    <td class="available">30</td>
                    <td class="available">31</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="available">8:00 - 9:00</td>
                    <td class="available">9:00 - 10:00</td>
                    <td class="available">10:00 - 11:00</td>
                    <td class="not-available">11:00 - 12:00</td>
                </tr>
                <tr>
                    <td class="not-available">12:00 - 13:00</td>
                    <td class="available">14:00 - 15:00</td>
                    <td class="available">15:00 - 16:00</td>
                    <td class="not-available">16:00 - 17:00</td>
                </tr>
                <tr>
                    <td class="not-available">17:00 - 18:00</td>
                    <td class="available">18:00 - 19:00</td>
                    <td class="available">19:00 - 20:00</td>
                    <td class="not-available">20:00 - 21:00</td>
                </tr>
            </table>
        </div>
            


    </div>

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