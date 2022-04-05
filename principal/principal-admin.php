<?php

include('../auth/server.php');
if (empty($_SESSION['username'])){
        header('location: ../auth/login.php');
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Responsive Website Design</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="#" class="logo">Service<span>.</span></a>
        <div class="menuToggle" onclick="toggleMenu();"></div>
        <ul class="navigation">
            <li><a href="#banner" onclick="toggleMenu();">Home</a></li>
            <li><a href="#about" onclick="toggleMenu();">About</a></li>
            <li><a href="#menu" onclick="toggleMenu();">Menu</a></li>
            <li><a href="#expert"onclick="toggleMenu();">Expert</a></li>
            <li><a href="#testimonials"onclick="toggleMenu();">Testimonials</a></li>
            <li><a href="#contact"onclick="toggleMenu();">Contact</a></li>
            <li><a href="#">Programari</a></li>
        </ul>
    </header>
    <section id="banner">
      <div class="banner-text">
            <h2> Hello, <?php echo $_SESSION['username']; ?> !  </h2>
           
      </div>
  </section>
    <section class="banner" id="banner">
        <div class="content">
            <h2>Always Choose Good</h2>
            <p> Ne gandim la clientii nostri ca la niste invitati la petrecerea pe care am organizat-o.
                 Este misiunea noastra de zi cu zi de a imbunatati fiecare aspect la experientei clientului”. 
                 Jeff Bezos, CEO al Amazon.com
            </p>
            <a href="#menu" class="btn">Our Menu</a>
        </div>
    </section>


    <section class="about" id="about">
        <div class="row">
            <div class="col50">
                <h2 class="titleText"><span>A</span>bout Us</h2>
                <p>. “Consumatorii sunt statistici. Clientii sunt oameni”. Stanley Marcus, fost presedinte de consiliu director la Neiman Marcus
                     “Daca nu ai grija de clientii tai, o va face altcineva”. Autor necunoscut
                    “Exista un singur sef. Clientul. Si acesta poate sa-i concedieze pe toti din companie, de la presedintele consiliului director in jos, prin simplul gest de a-si cheltui banii in alta parte”. Sam Walton
                </p>
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
            <h2 class="titleText">Client <span>S</span>ervice</h2>
            <p>
                “Apropie-te mai mult ca niciodata de clientii tai. Du-te atat de aproape, incat sa le poti spune ce nevoie au inainte ca ei insisi sa stie”. Steve Jobs, fondator al Apple
                “Clientii nu se asteapta sa fii perfect. Se asteapta insa sa rezolvi lucrurile cand acestea nu merg”. Donald Porter, V.P. al British Airways
                “Un client multumit valoreaza mai mult decat o campanie publicitara de 10.000 de dolari”. Jim Rohn, antreprenor si speaker motivational
                “Petrece-ti cat mai mult timp vorbind direct cu clientii. Vei fi surprins sa aflii cate companii nu-si apleaca urechea la clienti”. Ross Perot, Fondator al Electronic Data Systems si Perot Systems
            </p>
        </div>
        <div class="content">
            <div class="box">
                <div class="imgBx">
                    <img src="m1.jpg">
                </div>
                <div class="text">
                    <h3>Reparatii Trotineta Electrica</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="m2.jpg">
                </div>
                <div class="text">
                    <h3>Reparatii Motocicleta</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="m3.jpg">
                </div>
                <div class="text">
                    <h3>Reparatii Bicicleta</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="m4.jpg">
                </div>
                <div class="text">
                    <h3>Reparatii trotineta</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="m5.jpg">
                </div>
                <div class="text">
                    <h3>Reparatii Bicicleta</h3>
                </div>
            </div>
            <div class="box">
                <div class="imgBx">
                    <img src="m6.jpg">
                </div>
                <div class="text">
                    <h3>Reparatii Bicicleta</h3>
                </div>
            </div>
            <div class="title">
                <a href="#" class="btn">View All</a>
            </div>
        </div>
    </section>

    <section class="expert" id="expert">
        <div class="title">
            <h2 class="titleText">Our Service <span>E</span>xpert</h2>
            <p>Cei 4 muschetari</p>
        </div>
        <div class="content">
            <div class="box">
                <div class="imgBx">
                    <img src="f1.jpg">
                </div>
                <div class="text">
                    <h3>The Rock </h3>
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
            <h2 class="titleText">They <span>S</span>aid About Us</h2>
            <p>Ceva de zis aici</p>
        </div>
        <div class="content">
            <div class="box">
                <div class="imgBx">
                    <img src="testi1.jpg">
                </div>
                <div class="text">
                    <p>
                         Foarte bun.
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
                         Exceptional.
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
                        Fara cuvinte.
                    </p>
                    <h3>Andreea</h3>
                </div>
            </div>
        </div>

    </section>


    <section class="contact" id="contact">
        <div class="title">
            <h2 class="titleText"> <span>L</span>asati un mesaj</h2>
            <p>Ajuta-ne sa devenim mai buni</p>
        </div>
        <div class="contactForm">
            <h3>Send Message</h3>
            <div class="inputBox">
                <input type="email" placeholder="Name">
            </div>
            <div class="inputBox">
                <input type="text" placeholder="Email">
            </div>
            <div class="inputBox">
                <textarea placeholder="Message"></textarea>
            </div>
            <div class="inputBox">
                <input type="submit" value="Send">
            </div>
        </div>

    </section>




    <script type="text/javascript">
        window.addEventListener('scroll',function(){
            const header =document.querySelector('header');
            header.classList.toggle("sticky",window.scrollY>0);
        });   

        function toggleMenu(){
            const menuToggle=document.querySelector('.menuToggle');
            const navigation=document.querySelector('.navigation');
            menuToggle.classList.toggle('active');
            navigation.classList.toggle('active');
        }
    </script>
</body>
</html>