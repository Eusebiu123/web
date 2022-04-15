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
            <section>
                <h3>2.1. Front-end:</h3>
                <p>
                    Proiectul conține mai multe pagini separate în 2 categorii în funcție de cine are dreptul să le acceseze: pentru utilizatori normali  
                    și pentru administratori, alături de o pagină de autentificare.
                </p>
                <section>
                    <h4>2.1.1. Paginile pentru utilizatorii normali:</h4>
                    <p>Utilizatorii obișnuiți au acces la o pagină principală ce conține link-uri spre un calendar cu zile disponibile pentru reparații și 
                        spre un formular pentru realizarea de comenzi pentru reparații.
                    </p>
                </section>
                <section>
                    <h4>2.1.2. Paginile pentru administratori:</h4>
                    <p>Administratorii au acces la propria pagină principală ce conține link-uri spre o pagină unde pot observa cererile primite de la utilizatori 
                        și spre o pagină unde pot realiza comenzi pentru piese de schimb de la anumiți furnizori.
                    </p>
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
