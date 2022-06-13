<?php

include('../auth/server.php');
if (empty($_SESSION['username'])) {
    header('location: ../auth/login.php');
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <a href="#" class="logo">Service<span>.</span></a>
        <div class="menuToggle" onclick="toggleMenu();"></div>
        <ul class="navigation">
            <li><a href="#banner" onclick="toggleMenu();">Acasă</a></li>
            <li><a href="#about" onclick="toggleMenu();">Despre</a></li>
            <li><a href="../initial/index.php" onclick="toggleMenu();">Formular Programări</a></li>
            <li><a href="../admin/raspuns_programari.php" onclick="toggleMenu();">Raspunsuri programări</a></li>
            <li><a href="principal-utilizator.php?logout='1'" onclick="toggleMenu();">Logout</a> </li>
        </ul>
    </header>
    <section id="banner">
        <div class="banner-text">
            <h2> Bun venit, <?php echo $_SESSION['username']; ?>! </h2>
            <a class="btn" href="../initial/index.php">Formular Programări</a>
            <a class="btn" href="../admin/raspuns_programari.php">Raspunsuri programări</a>
        </div>
    </section>
    <section class="banner" id="banner">
        <div class="content">
            <h2>Cea Mai Bună Alegere</h2>
            <p> Ne gandim la clientii nostri ca la niste invitati la petrecerea pe care am organizat-o.
                Este misiunea noastra de zi cu zi de a imbunatati fiecare aspect la experientei clientului” -
                Jeff Bezos
            </p>
        </div>
    </section>


    <section class="about" id="about">
        <div class="row">
            <div class="col50">
                <h2 class="titleText"><span>D</span>espre Noi</h2>
                <p>“Consumatorii sunt statistici. Clientii sunt oameni.” - Stanley Marcus, fost presedinte de consiliu director la Neiman Marcus</p>
                <p>“Daca nu ai grija de clientii tai, o va face altcineva.” - Autor necunoscut</p>
                <p>“Exista un singur sef. Clientul. Si acesta poate sa-i concedieze pe toti din companie,
                    de la presedintele consiliului director in jos, prin simplul gest de a-si cheltui banii in alta parte.” - Sam Walton</p>
            </div>
            <div class="col50">
                <div class="imgBx">
                    <img src="a1.jpg">
                </div>
            </div>
        </div>

    </section>


    <section class="menu" id="menu">
        <div class="title">
            <h2 class="titleText"><span>S</span>ervicii clienți</h2>
            <p>“Apropie-te mai mult ca niciodata de clientii tai. Du-te atat de aproape, incat sa le poti spune ce nevoie au inainte ca ei insisi sa stie.” - Steve Jobs, fondator al Apple</p>
            <p>“Clientii nu se asteapta sa fii perfect. Se asteapta insa sa rezolvi lucrurile cand acestea nu merg.” - Donald Porter, V.P. al British Airways</p>
            <p>“Un client multumit valoreaza mai mult decat o campanie publicitara de 10.000 de dolari.” - Jim Rohn, antreprenor si speaker motivational</p>
            <p>“Petrece-ti cat mai mult timp vorbind direct cu clientii. Vei fi surprins sa aflii cate companii nu-si apleaca urechea la clienti.” - Ross Perot, Fondator al Electronic Data Systems si Perot Systems</p>
        </div>
        <div class="content">
            <div class="box">
                <div class="imgBx">
                    <img src="m1.jpg">
                </div>
                <div class="text">
                    <h3>Reparații Trotinetă Electrică</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="m2.jpg">
                </div>
                <div class="text">
                    <h3>Reparații Bicicletă</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="m3.jpg">
                </div>
                <div class="text">
                    <h3>Reparații Motocicletă</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="m4.jpg">
                </div>
                <div class="text">
                    <h3>Reparații trotinetă</h3>
                </div>
            </div>
            <div class="title">
                <a href="#" class="btn">Titlu</a>
            </div>
        </div>
    </section>

    <section class="expert" id="expert">
        <div class="title">
            <h2 class="titleText"><span>E</span>xperții</h2>
            <p>Cei 4 muschetari</p>
        </div>
        <div class="content">
            <div class="box">
                <div class="imgBx">
                    <img src="f1.jpg">
                </div>
                <div class="text">
                    <h3>The Rock</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="f2.jpg">
                </div>
                <div class="text">
                    <h3>Vin Diesel</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="f3.webp">
                </div>
                <div class="text">
                    <h3>Paul Walker</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="f4.jpg">
                </div>
                <div class="text">
                    <h3>Sung Kang</h3>
                </div>
            </div>
        </div>
    </section>


    <section class="testimonials" id="testimonials">
        <div class="title white">
            <h2 class="titleText"><span>C</span>e Spun Clienții</h2>
        </div>
        <div class="content">
            <div class="box">
                <div class="imgBx">
                    <img src="testi1.jpg">
                </div>
                <div class="text">
                    <p>
                        Un service minunat! Doar mă programez și când merg mă rezolvă imediat.
                    </p>
                    <h3>Ioana</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="testi2.jpg">
                </div>
                <div class="text">
                    <p>
                        Excepțional!
                    </p>
                    <h3>Ionel</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="testi3.jpg">
                </div>
                <div class="text">
                    <p>
                        Fără cuvinte.
                    </p>
                    <h3>Andreea</h3>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            header.classList.toggle("sticky", window.scrollY > 0);
        });

        function toggleMenu() {
            const menuToggle = document.querySelector('.menuToggle');
            const navigation = document.querySelector('.navigation');
            menuToggle.classList.toggle('active');
            navigation.classList.toggle('active');
        }
    </script>
</body>

</html>