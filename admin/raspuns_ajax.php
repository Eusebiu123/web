<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/training.css">
</head>

<body>
  <section class="training__container">
    <!-- <?php
      // require_once "functii_php/classment_function.php";
    ?> -->
    <table class="training__table">
      <thead class="training__table__header">
        <tr>
          <th>Nume Vehicul</th>
          <th>Marca</th>
          <th>Piesa</th>
          <th>Data</th>
          <th>Ora</th>
          <th>Raspuns</th>
        </tr>
      </thead>
      <tbody id="data" class="training__table__body">
      </tbody>
    </table>
  </section>

</body>

</html>

<script>
  var ajax = new XMLHttpRequest();
  var method = "GET";
  var url = "functii_php/data.php";
  var asynchronous = true;

  ajax.open(method, url, asynchronous);
  //sendind ajax request
  ajax.send();

  //receiving response from data.php
  ajax.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //converting json back to array
      var data = JSON.parse(this.responseText);
      console.log(data); //for debugging

      //html value for <tbody>
      var html = "";
      // looping throught the data
      for (var a = 0; a < data.length; a++) {
        var nume_vehicul = data[a].nume_vehicul;
        var marca = data[a].marca;
        var piesa = data[a].piesa;
        var data = data[a].data;
        var ora = data[a].ora;
        var raspuns = data[a].raspuns;

        //appending  at html
        html += "<tr>";
        html += "<td>" + nume_vehicul + "</td>";
        html += "<td>" + marca + "</td>";
        html += "<td>" + piesa + "</td>";
        html += "<td>" + data + "</td>";
        html += "<td>" + ora + "</td>";
        html += "<td>" + raspuns + "</td>";
        html += "</tr>";
      }

      //replacing <tbody> of <table>
      document.getElementById("data").innerHTML = html;
    }
  }
</script>