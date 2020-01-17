function color_play() {

  if (document.random_colors === undefined) return;

  var rc = document.random_colors;

  for (var x=0; x<3; x++)
  {
    var rand = Math.floor(Math.random() * 10);

    rc[x] += rand;

    rc[x] -= rand;
  }

}
