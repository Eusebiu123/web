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
                <strong>MAI</strong>
                <strong>2022</strong>
            </div>

            <table>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>The</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td class="not-available">6</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>9</td>
                    <td>10</td>
                    <td class="not-available">11</td>
                    <td>12</td>
                    <td>13</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>15</td>
                    <td class="not-available">16</td>
                    <td>17</td>
                    <td>18</td>
                    <td>19</td>
                    <td class="not-available">20</td>
                    <td>21</td>
                </tr>
                <tr>
                    <td>22</td>
                    <td>23</td>
                    <td>24</td>
                    <td>25</td>
                    <td class="not-available">26</td>
                    <td>27</td>
                    <td>28</td>
                </tr>
                <tr>
                    <td>29</td>
                    <td>30</td>
                    <td>31</td>
                    <td class="no"></td>
                    <td class="no"></td>
                    <td class="no"></td>
                    <td class="no"></td>
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