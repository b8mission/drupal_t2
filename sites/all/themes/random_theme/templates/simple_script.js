function do_it()
{
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }

  document.getElementById('header').style.background = color;
}
do_it();
//setInterval(do_it, 1000);
