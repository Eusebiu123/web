<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <p>Tabelul cu programări prezintă toate programările care au primit răspuns de la administrator. Acest tabel conține 6 câmpuri:</p>
                        <ul>
                            <li>Nume vehicul</li>
                            <li>Marca</li>
                            <li>Piesa</li>
                            <li>Data</li>
                            <li>Ora</li>
                            <li>Răspuns</li>
                        </ul>
                    </section>
                </section>
            </section>
            <section>
                <h3>2.2. Back-end:</h3>
                <p>
                    Partea de back-end va fi implementată în proiectul final.
                </p>
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
