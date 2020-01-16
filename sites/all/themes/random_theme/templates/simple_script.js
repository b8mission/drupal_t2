function do_it()
{
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }

  document.getElementsByClassName('clearfix region region-header')[0].style.background = color;
}

do_it();
