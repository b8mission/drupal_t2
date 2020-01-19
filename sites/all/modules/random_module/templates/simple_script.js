function loadDoc() {
  var url = document.getElementById('randomForm1').elements['route'].value;

  document.getElementById('randomButton').hidden = true;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {

      fillTable(this.responseText);
    }
  };
  xhttp.open("GET", url, true);
  xhttp.send();
}


function fillTable(data) {
  data = JSON.parse(data);
  document.resp = data;

  data = data['data'];

  table = document.getElementById("randomNodes");

  table.innerHTML = '';

  for (i = 0; i < data.length; i++) {
    r = table.insertRow();
    c = r.insertCell();
    c.innerHTML = data[i]['title'][0]['value'];

    if (data[i]['body'] === undefined) continue;

    c = r.insertCell();
    c.innerHTML = data[i]['body'][0]['value'];
  }

  document.getElementById('randomButton').value = 'You won ' + data.length + ' random device node/s.';
  document.getElementById('randomButton').hidden = false;

}
