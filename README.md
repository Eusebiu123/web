<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyMaT (Cycling Maintenance Web Tool) - Raport Tehnic</title>
</head>

<body>
    <article>
        <header>
            <h1>CyMaT (Cycling Maintenance Web Tool) - Raport Tehnic</h1>
        </header>
        <div typeof="sa:AuthorsList" role="contentinfo">
            <h2>Autori:</h2>
            <ul>
                <li typeof="sa:ContributorRole" property="schema:author">
                    <span typeof="schema:Person" property="schema:author">
                        <meta property="schema:givenName" content="Andrei">
                        <meta property="schema:familyName" content="Cîrjanu">
                        <span property="schema:name">Andrei Cîrjanu</span>
                    </span>
                </li>
                <li typeof="sa:ContributorRole" property="schema:author">
                    <span typeof="schema:Person" property="schema:author">
                        <meta property="schema:givenName" content="Alexandru-Robert">
                        <meta property="schema:familyName" content="Coțofan">
                        <span property="schema:name">Alexandru-Robert Coțofan</span>
                    </span>
                </li>
                <li typeof="sa:ContributorRole" property="schema:author">
                    <span typeof="schema:Person" property="schema:author">
                        <meta property="schema:givenName" content="Eusebiu">
                        <meta property="schema:familyName" content="Popescu">
                        <span property="schema:name">Eusebiu Popescu</span>
                    </span>
                </li>
            </ul>
        </div>
        <section role="doc-introduction">
            <h2>1. Introducere:</h2>
            <section role="doc-abstract">
                <h3>1.1. Abstract:</h3>
                <p>
                    Creați un sistem online de management al programărilor și stocurilor unui operatii de service de motociclete, 
                    biciclete, trotinete (electrice sau nu). Fiecare client va consulta calendarul service-ului, iar apoi va completa 
                    un formular cu data și ora dorită, plus detalii despre problemă, putând adăuga inclusiv fișiere multimedia (imagini și filme). 
                    Administratorul afacerii va putea respinge programarea adăugând un mesaj explicativ: "Ne pare rău, dar nu avem 
                    în stoc piesele necesare pentru reparație, reveniți în S săptămâni" sau o va putea aproba, oferind și un 
                    preț estimativ, plus alte detalii de interes. De asemenea, aplicația îi va permite acestuia să țină evidența 
                    stocurilor existente, cât și a comenzilor date către furnizori. Sistemul va putea importa date în format CSV și JSON. 
                    Pentru exportul datelor, se va recurge la oricare dintre formatele CSV, JSON, PDF. Bonus: simularea activitatii service-ului 
                    pe o perioada de timp: luni/ani.
                </p>
            </section>
        </section>
        <section>
            <h2>2. Descriere:</h2>
            <p>În cele ce urmează se va descrie implementarea cerințelor pentru proiectul CyMaT. Raportul cuprinde două secțiuni principale: front-end-ul site-ului 
                și implementările funcțiilor în back-end.
            </p>
            <section>
                <h3>2.1. Front-end:</h3>
                <p>
                    Proiectul conține mai multe pagini separate în 2 categorii în funcție de cine are dreptul să le acceseze: pagini pentru utilizatori normali  
                    și pentru administratori, alături de pagini comune de autentificare și înregistrare.
                </p>
                <section>
                    <h4>2.1.1. Paginile de autentificare și înregistrare:</h4>
                    <p>Prima pagină la care are acces un utilizator este pagina de autentificare, unde trebuie să își introducă username-ul și parola pentru a intra în 
                        paginile principale. În cazul în care nu are cont pe pagină, își poate crea unul pe pagina de înregistrare.
                    </p>
                    <p>Pagina de înregistrare este vizual similară cu cea de autentificare. Aici utilizatorii își pot crea un cont introducând un username unic, o adresă 
                        de e-mail și parola, care trebuie introdusă de două ori pentru confirmare. Toate câmpurile sunt obligatorii. După crearea unui cont și 
                        autentificare, utilizatorul poate accesa pagina principală.
                    </p>
                </section>
                <section>
                    <h4>2.1.2. Paginile pentru utilizatori obișnuiți:</h4>
                    <p>După autentificare, utilizatorul are acces la pagina principală, ce conține un header cu mai multe opțiuni: Home, About, Menu, Expert 
                        și Testimonials fac referire la diferite porțiuni ale paginii, Formular Programari trimite la calendarul cu zile disponibile pentru programari, 
                        iar Raspunsuri programari trimite la un tabel cu programările care au primit răspuns.
                    </p>
                    <section>
                        <h5>2.1.2.1. Calendarul și formularul de programare:</h5>
                        <p>Pagina calendarului este compusă din două părți: prima parte afișează luna pentru care este prezentat calendarul, iar sub aceasta sunt 
                            3 butoane: butonul stâng afișează luna anterioară, butonul drept cea următoare, iar cel din mijloc trimite la luna curentă. A doua parte 
                            a paginii este calendarul efectiv: un tabel cu 7 coloane și un număr de celule egal cu numărul de zile din lună. Fiecare celulă conține 
                            numărul zilei respective și, sub număr, un buton. Aceste celule pot fi, după caz:
                        </p>
                        <ul>
                            <li>Verzi, dacă există cel puțin un interval orar disponibil în ziua respectivă. În acest caz, butonul va arăta numărul de 
                                intervale disponibile, iar apăsarea lui va duce la alegerea intervalului și completarea unui formular cu detalii despre programare.
                            </li>
                            <li>Roșii, dacă ziua este complet indisponibilă, butonul de sub număr fiind neapăsabil. Acest fapt poate proveni dintr-una din următoarele 
                                cauze:
                                <ul>
                                    <li>Ziua deja s-a terminat, caz în care textul din buton va fi "Day passed".</li>
                                    <li>Ziua este o sâmbătă sau o duminică, caz în care textul va fi "Week-end".</li>
                                    <li>Toate intervalele din acea zi sunt ocupate. Butonul va avea drept text "All booked".</li>
                                </ul>
                            </li>
                        </ul>
                        <p>
                            La alegerea unei zile prin apăsarea butonului respectiv, utilizatorul este trimis pe o a doua pagină în care va alege intervalul orar dintre 
                            cele afișate și va completa un formular cu detalii despre programarea dorită. Similar cu alegerea unei zile, intervalele disponibile sunt 
                            butoane verzi, iar cele indisponibile roșii. Formularul conține 7 câmpuri, din care 5 obligatorii:
                        </p>
                        <ul>
                            <li>Câmpul "Date" este read-only și arată ziua aleasă.</li>
                            <li>Câmpul "Timeslot" este read-only, obligatoriu și arată intervalul orar ales prin apăsarea butonului respectiv. Apăsarea unui alt buton verde
                                va determina schimbarea sa cu un interval nou.
                            </li>
                            <li>Câmpul "Nume Vehicul" este obligatoriu, de tip text. Utilizatorul introduce numele vehiculului dorit pentru revizie.</li>
                            <li>Câmpul "Marca" este obligatoriu, de tip text. Utilizatorul introduce marca vehiculului.</li>
                            <li>Câmpul "Piesa" este obligatoriu, de tip text. Utilizatorul introduce piesa la care dorește să facă revizie sau să o înlocuiască.</li>
                            <li>Câmpul "Detalii" este obligatoriu, de tip text. Utilizatorul introduce detalii despre revizia dorită, fie ea o reparare sau o înlocuire de piesă.</li>
                            <li>Câmpul "Imagine / Video" este opțional, de tip fișier. Utilizatorul încarcă o imagine sau un videoclip cu componenta în cauză.</li>
                        </ul>
                        <p>
                            La final, utilizatorul apasă butonul "Programare" pentru a trimite administratorului programarea.
                        </p>
                    </section>
                    <section>
                        <h5>2.1.2.2. Tabelul cu programări:</h5>
                        <p>Tabelul cu programări prezintă toate programările care au primit răspuns de la administrator. Acest tabel conține 6 câmpuri: Nume vehicul, Marca, 
                            Piesa, Data, Ora, Răspuns. </p>
                    </section>
                </section>
                <section>
                    <h4>2.1.3. Paginile pentru administrator:</h4>
                    <p>În cazul în care utilizatorul autentificat este un administrator, acesta va fi trimis spre o pagină specială cu un header diferit: 
                        paginile disponibile numai administratorilor sunt Programări, Stoc Existent și Comenzi Furnizor.
                    </p>
                    <section>
                        <h5>2.1.3.1. Pagina cu programări realizate:</h5>
                        <p>Pe această pagină administratorul observă toate programările făcute până în prezent, având opțiunea de a le rezolva pe toate apăsând un singur 
                            buton: Rezolvă Programările. Acest tabel are 6 câmpuri: Nume utilizator, Nume vehicul, Marca, Piesa, Data, Ora.
                        </p>
                    </section>
                    <section>
                        <h5>2.1.3.2 Stocul Existent:</h5>
                        <p>Pe această pagină, administratorul poate vedea stocurile de piese rămase, organizate într-un tabel cu 5 câmpuri: ID, Nume vehicul, Marca, 
                            Piesa, Cantitate. De asemenea, sub tabel există mai multe butoane pentru importarea și exportarea datelor: importarea se poate face în format 
                            CSV sau JSON și necesită un fișier, iar exportarea se poate face în CSV, JSON sau PDF.
                        </p>
                    </section>
                    <section>
                        <h5>2.1.3.3. Comenzi Furnizor:</h5>
                        <p>Aici, administratorul poate realiza comenzi spre furnizori prin intermediul unui formular. În acest formular administratorul introduce 
                            numele service-ului, adresa de e-mail, numărul de telefon și va alege tipul de vehicul, marca, piesa necesară și cantitatea. La apăsarea 
                            butonului Submit, piesele vor fi adăugate automat în tabelul de stoc.
                        </p>
                    </section>
                </section>
            </section>
            <section>
                <h3>2.2. Back-end:</h3>
                <p>
                    Partea de back-end a proiectului constă dintr-o multitudine de funcții PHP și JavaScript prin care sunt trimise date spre și dinspre baza de date 
                    asociată site-ului, pentru a asigura funcționarea sa. În cele ce urmează se vor prezenta baza de date și funcțiile care compun back-end-ul.
                </p>
                <section>
                    <h4>2.2.1. Baza de date:</h4>
                    <p>Baza de date conține toate datele necesare funcționării corecte a site-ului web. Realizată folosind un server de tip MariaDB, baza conține trei 
                        tabele care administrează cele trei tipuri de date folosite:
                    </p>
                    <ul>
                        <li>Users: Acest tabel conține toți utilizatorii înregistrați, informațiile despre aceștia fiind organizate în 4 coloane: id este id-ul 
                            unic pentru fiecare utilizator, username este numele de cont ales, email este adresa de e-mail înregistrată la momentul creării contului, 
                            iar password este parola utilizatorului, criptată folosind funcția hash MD5.
                        </li>
                        <li>Stoc: Acest tabel conține toate piesele din stocul service-ului și informații despre ele. Tabelul conține 5 coloane: id, nume_vehicul 
                            este tipul vehiculului de proveniență al piesei, marca este marca vehiculului, piesa este tipul de piesa din stoc, iar cantitate este numărul
                            de astfel de piese în posesia service-ului.
                        </li>
                        <li>Bookings: Acest tabel administrează toate programările făcute de utilizatori la service, conținând toate informațiile necesare în 11 
                            coloane: id, name este numele utilizatorului care s-a programat, date este ziua programării, timeslot este intervalul orar rezervat, 
                            nume_vehicul este tipul de vehicul pentru care se dorește revizia, marca este marca vehiculului, piesa este piesa care trebuie reparată 
                            sau schimbată, detalii sunt toate detaliile în plus incluse în comandă, nume_fisier este numele fișierului atașat, location este locația 
                            fișierului, iar raspuns este răspunsul primit de la administrator atunci când acesta rezolvă programarea.
                        </li>
                    </ul>
                    <p>Folosind interogări SQL, funcțiile PHP interacționează cu această bază de date, preluând date pentru a le afișa utilizatorilor sau introducând 
                        date, după caz.
                    </p>
                </section>
                <section>
                    <h4>2.2.2. Funcțiile PHP:</h4>
                    <p>PHP este limbajul de programare utilizat pentru back-end. Prin urmare, toate elementele de cod PHP au rolul de a asigura funcționalitatea 
                        fiecărui aspect al site-ului web ce nu ține de design. Aceste funcționalități se împart în două mari categorii: comunicarea cu baza 
                        de date și comunicarea cu clientul.
                    </p>
                    <section>
                        <h5>2.2.2.1. Comunicarea cu baza de date:</h5>
                        <p>Pentru a putea comunica cu baza de date, primul și cel mai important pas este conectarea la aceasta. Acest lucru se face prin apelul 
                            funcției mysqli_connect() care primește ca parametri adresa serverului, numele de utilizator, parola și baza de date la care se dorește 
                            conectarea, astfel:
                        </p>
                        <figure typeof="schema:SoftwareSourceCode">
                            <pre>
                                <code>
$mysqli=mysqli_connect('localhost','root','','registration');
                                </code>
                            </pre>
                        </figure>
                        <p>După realizarea conectării, comunicarea se realizează prin interogări SQL spre baza de date. În funcție de tipul interogării, variabilele 
                            folosite pentru reținerea datelor sunt prelucrate pentru trimiterea în bază sau atribuirea valorilor primite. În cele ce urmează vor fi 
                            prezentate câteva interogări folosite în proiect:
                        </p>
                        <figure typeof="schema:SoftwareSourceCode">
                            <figcaption>Interogare folosind un prepared statement în care se creează o nouă linie în tabelul bookings, folosind 9 variabile:</figcaption>
                            <pre>
                                <code>
$stmt = $mysqli->prepare("INSERT INTO bookings (name,date,timeslot,nume_vehicul,marca,piesa,detalii,nume_fisier,location) VALUES (?,?,?,?,?,?,?,?,?)");
$stmt->bind_param('sssssssss', $name, $date, $timeslot, $nume_vehicul, $marca, $piesa, $detalii, $nume_fisier, $target_file);
$stmt->execute();
                                </code>
                            </pre>
                        </figure>
                        <figure typeof="schema:SoftwareSourceCode">
                            <figcaption>Interogare în care se obțin toți utilizatorii cu un anumit e-mail, dat ca variabilă. Rezultatul este înregistrat 
                                într-o variabilă proprie:
                            </figcaption>
                            <pre>
                                <code>
$sql="SELECT * FROM users WHERE email='$email'";
$result=mysqli_query($mysqli,$sql);
                                </code>
                            </pre>
                        </figure>
                        <figure typeof="schema:SoftwareSourceCode">
                            <figcaption>Interogare în care se obțin toate programările fără răspuns:</figcaption>
                            <pre>
                                <code>
$sql = 'SELECT * FROM bookings WHERE raspuns is NULL';
$rez = mysqli_query($mysqli, $sql);
                                </code>
                            </pre>
                        </figure>
                        <p>Apelând astfel de funcții, baza de date primește date de la client pentru a fi actualizată, sau oferă date care vor fi folosite pentru a 
                            răspunde cererilor clientului.
                        </p>
                    </section>
                    <section>
                        <h5>2.2.2.2. Comunicarea cu clientul:</h5>
                        <p>Toate interogările spre baza de date și variabilele folosite au un scop major: răspunderea la cererile clientului, acesta solicitând 
                            date de la server sau trimițându-le. Deoarece, în funcție de pagina pe care se află clientul, fiecare cerere poate să difere de celelalte, 
                            server-ul trebuie să se poată adapta la ele și să răspundă corespunzător. Astfel, fiecare pagină web conține propriul cod PHP care primește 
                            date fie de la baza de date prin intermediul interogărilor SQL, fie de la client folosind două verbe HTTP: GET și POST. În cele ce urmează 
                            va fi prezentat codul folosit pentru fiecare pagină web:
                        </p>
                        <p>Primele pagini cu care va interacționa utilizatorul sunt paginile de autentificare și înregistrare. La bază au aceleași fișiere de cod, 
                            responsabile cu administrarea tabelului users și semnalarea potențialelor erori:
                        </p>
                        <ul>
                            <li>La primirea datelor de la utilizator prin intermediul unui formular, folosind metoda POST, este verificată corectitudinea datelor 
                                primite: în cazul în care datele provin de la pagina de autentificare, se verifică dacă există un câmp în tabel cu același nume și parolă: 
                                dacă da, utilizatorul are acces la pagina principală, iar în caz contrar cererea este respinsă și un mesaj de eroare: "Nume sau 
                                parolă incorecte" este trimis.
                            </li>
                            <li>
                                Pentru pagina de înregistrare, toate câmpurile sunt obligatorii, iar utilizatorul nu poate folosi un nume sau 
                                o adresă de e-mail care există deja în baza de date.
                            </li>
                        </ul>
                        <figure typeof="schema:SoftwareSourceCode">
                            <figcaption>Codul pentru verificarea existenței numelui de utilizator sau parolei:</figcaption>
                            <pre>
                                <code>
$sql="SELECT * FROM users WHERE email='$email'";
$result=mysqli_query($mysqli,$sql);
if(mysqli_num_rows($result)==1){
    array_push($errors, "Acest email a fost deja utilizat");
}
$sql="SELECT * FROM users WHERE username='$username'";
$result=mysqli_query($mysqli,$sql);
if(mysqli_num_rows($result)==1){
    array_push($errors, "Acest username a fost deja utilizat");
}
                                </code>
                            </pre>
                        </figure>
                        <p>Pentru un utilizator obișnuit, cele mai importante pagini sunt formularul de programare și verificarea programărilor trimise. Astfel, o 
                            parte semnificativă din porțiunea PHP a proiectului este concentrată aici, asigurând funcționalitatea completă a cererii de programare:
                        </p>
                        <ul>
                            <li>Prima parte a formularului, calendarul, este implementat prin generarea unui tabel în mai mulți pași: primul pas este obținerea lunii 
                                curente și crearea butoanelor pentru afișarea lunilor precedente și următoare. Al doilea pas este crearea bazei calendarului, 
                                creând header-ele tabelului și populând celulele cu numele fiecărei zile. Al treilea pas este construirea calendarului: dacă prima zi 
                                nu este luni, tabelul este umplut cu celule goale până prima zi coincide cu numele zilei. Dacă ziua este sâmbătă, duminică sau înainte 
                                de prezent, celula corespunzătoare este marcată indisponibilă. La final, dacă toate intervalele de timp ale zilei sunt ocupate, este 
                                marcată indisponibilă, cele rămase prezentând numărul de intervale rămase.
                            </li>
                            <li>A doua parte a formularului este alegerea orei și completarea formularului în sine: similar cu alegerea zilei, pentru fiecare oră se 
                                verifică dacă aparține deja unei programări, caz în care este marcată indisponibilă și imposibil de apăsat. Formularul în sine 
                                folosește metoda POST pentru a trimite datele la apăsarea butonului "Trimite".
                            </li>
                            <li>După primirea datelor, acestea sunt atribuite unor variabile corespunzătoare și, prin intermediul lor, încărcate în baza de date folosind 
                                interogarea prezentată mai sus.
                            </li>
                        </ul>
                        <figure typeof="schema:SoftwareSourceCode">
                            <figcaption>Cod pentru verificarea dacă ziua este sâmbătă sau duminică:</figcaption>
                            <pre>
                                <code>
$date = "$year-$month-$currentDayRel";
$dayname = strtolower(date('l', strtotime($date)));
if ($dayname == 'saturday' || $dayname == 'sunday') {
    $calendar .= "&lt;td class='td-unavailable'>&lt;h4>$currentDay&lt;/h4> &lt;button class='btn-unavailable'>Week-end&lt;/button>";
} elseif ($date &lt; date('Y-m-d')) {
    $calendar .= "&lt;td class='td-unavailable'>&lt;h4>$currentDay&lt;/h4> &lt;button class='btn-unavailable'>Day passed&lt;/button>";
}
                                </code>
                            </pre>
                        </figure>
                        <figure typeof="schema:SoftwareSourceCode">
                            <figcaption>Codul pentru primirea datelor din formular și introducerea lor în baza de date:</figcaption>
                            <pre>
                                <code>
if (isset($_POST['submit'])) {
    $nume_fisier = $_FILES['file']['name'];
    $target_dir = "video/";
    $target_file = $target_dir . $nume_fisier;
    $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $extensions_arr = array("mp4", "avi", "3gp", "mov", "mpeg", "jpg", "png");
    $nume_vehicul = $mysqli->real_escape_string($_POST['nume_vehicul']);
    $marca = $mysqli->real_escape_string($_POST['marca']);
    $piesa = $mysqli->real_escape_string($_POST['piesa']);
    $detalii = $mysqli->real_escape_string($_POST['detalii']);
    $name = $_SESSION['username'];
    $date = $_POST['date'];
    $timeslot = $_POST['timeslot'];
    $stmt = $mysqli->prepare("select * from bookings where date = ? AND timeslot=?");
    $stmt->bind_param('ss', $date, $timeslot);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $stmt = $mysqli->prepare("INSERT INTO bookings (name,date,timeslot,nume_vehicul,marca,piesa,detalii,nume_fisier,location) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('sssssssss', $name, $date, $timeslot, $nume_vehicul, $marca, $piesa, $detalii, $nume_fisier, $target_file);
            $stmt->execute();
            $bookings[] = $timeslot;
            $stmt->close();
            $mysqli->close();
            sleep(1);
            header("Location: ../principal/principal-utilizator.php");
        }
    }  
}
                                </code>
                            </pre>
                        </figure>
                        <ul>
                            <li>Tabelul cu programările trimise afișează doar programările care au primit răspuns: acest lucru se realizează printr-o interogare SQL, 
                                verificându-se dacă coloana raspuns nu este vidă. Datele primite sunt afișate în tabel:
                            </li>
                        </ul>
                        <figure typeof="schema:SoftwareSourceCode">
                            <pre>
                                <code>
&lt;?php
while ($inreg = mysqli_fetch_assoc($result)) {
    if ($inreg['raspuns'] != NULL) {

?>
    &lt;tr>
        &lt;td>&lt;?php echo $inreg['nume_vehicul']; ?>&lt;/td>
        &lt;td>&lt;?php echo $inreg['marca']; ?>&lt;/td>
        &lt;td>&lt;?php echo $inreg['piesa']; ?>&lt;/td>
        &lt;td>&lt;?php echo $inreg['date']; ?>&lt;/td>
        &lt;td>&lt;?php echo $inreg['timeslot']; ?>&lt;/td>
        &lt;td>&lt;?php echo $inreg['raspuns']; ?>&lt;/td>
    &lt;/tr>
&lt;?php
    }
}
?>
                                </code>
                            </pre>
                        </figure>
                    </section>
                </section>
            </section>
        </section>
        <section role="doc-conclusion">
            <h2>3. Concluzie:</h2>
            <p>În concluzie, această aplicație are rolul de a permite utilizatorilor obișnuiți să poată face programări la service-ul care administrează site-ul 
                pentru reparațiile solicitate și de a permite administratorilor să răspundă acestor programări din timp, aprobându-le sau respingându-le motivat.
            </p>
        </section>
    </article>
</body>

</html>
