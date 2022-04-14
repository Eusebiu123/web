<?php
include('../auth/server.php');

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comenzi-Furnizor</title>
    <link rel = "stylesheet" href = "style2.css">
</head>
<body>
    <div class="container-f">
    <div class="title-f">Formular</div>
    <form method="post"> <!-- action = -->
        <div class="company-f">
            <div class="input-f">
                <span class="details-f">Nume Service</span>
                <input type="text" placeholder="Introduceti numele" required>
            </div>
            <div class="input-f">
                <span class="details-f">Email</span>
                <input type="email" placeholder="Introduceti email" required>
            </div>
            <div class="input-f">
                <span class="details-f">Nr. telefon</span>
                <input type="tel" placeholder="Introduceti numarul" required>
            </div>
        </div>
        <div class="categorie-detalii-f">
            <span class="categorie-titlu-f">Tip vehicul</span>
            <div class="category-f">
            <input type="radio" id="motocicleta" name="type-veh" value="motocicleta">
            <label for="motocicleta">Motocicleta</label>
            <input type="radio" id="bicicleta" name="type-veh" value="bicicleta">
            <label for="bicicleta">Bicicleta</label><br>
            <input type="radio" id="trotineta" name="type-veh" value="trotineta">
            <label for="trotineta">Trotineta</label>
            <input type="radio" id="trotineta-el" name="type-veh" value="trotineta-el">
            <label for="trotineta-el">Trotineta Electrica</label>    
            </div>
        </div>
        <div class="marca-detalii-f">
        <label for="marca-veh-f">Marca vehicul</label>
            <select name="marca-f" id="marca-f">
                        <option value="1">Kawasaki</option>
                        <option value="2">Honda</option>
                        <option value="3">Indian</option>
                        <option value="4">Suzuki</option>
                        <option value="5">Pegas</option>
                        <option value="6">OEM</option>
                        <option value="7">Giant</option>
                        <option value="8">GT</option>
                        <option value="9">Cube</option>
                        <option value="10">Zero</option>
                        <option value="11">Lime</option>
                        <option value="12">Razor</option>
            </select><br>
        </div>
        <div class="piesa-detalii-f">
        <label for="piesa-veh-f">Piesa necesara</label>
            <select name="piesa-f" id="piesa-f">
                        <option value="1">Roata</option>
                        <option value="2">Cadran</option>
                        <option value="3">Ghidon</option>
                        <option value="4">Macara</option>
                        <option value="5">Maner</option>
                        <option value="6">Cauciuc</option>>
            </select>
        </div>
        <div class="cantitate-detalii">
            <label for="quantity">Cantitate:</label>
            <input type="number" id="quantity" name="quantity" min="1" max="100" step="1" value="1">
        </div>
        <div class="button-f">
            <input type="submit" value ="Submit">
        </div>
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