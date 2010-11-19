<?php
function display() {
  global $pc, $reg0, $reg1;
  print $reg1;
  $pc = $reg0;
}

$reg0 = 'exit';
$pc   = 'entry-point';
while (1) {
  switch ($pc) {
    case 'entry-point':              // #1 0 entry-point 0 ()
      $reg1 = "Hello, World!\n";     // +1 = '"Hello, World!\n"
      $pc   = '#2'; break;           // jump* 0 #2
    case '#2':                       // #2 0
      $pc   = 'display'; break;      // jump$ 0 display 1
    case 'display':
      display(); break;
    case 'exit':
      break 2;
  }
}

?>
