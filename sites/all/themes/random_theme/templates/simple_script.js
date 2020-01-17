function do_it()
{
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }

  random_colors = [ Math.floor(Math.random() * 255),
    Math.floor(Math.random() * 255),
    Math.floor(Math.random() * 255),
  ];

  color = 'rgb(' + random_colors[0] + ', ' + random_colors[1] + ', ' + random_colors[2] + ')';
  document.random_colors = random_colors;

  document.getElementById('header').style.background = color;
}
do_it();
//setInterval(do_it, 1000);
