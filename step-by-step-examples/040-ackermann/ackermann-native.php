<?php
function ack($m, $n) {
  if (0 == $m) {
    return $n+1;
  }
  if (0 == $n) {
    return ack($m-1, 1);
  }
  return ack($m-1, ack($m, $n-1));
}

$m = 3;
$n = 9;
$a = ack($m, $n);
print "ack($m,$n)=$a\n";
?>
