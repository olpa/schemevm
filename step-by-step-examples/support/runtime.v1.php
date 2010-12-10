<?php

function glo_exit() {
  exit();
}

function glo_display() {
  global $reg0, $reg1, $pc;
  print $reg1;
  $pc = $reg0;
}

function exec_scheme_code($pc_main) {
  global $pc, $reg0, $glo_exit;
  $reg0 = 'glo_exit';
  $pc   = $pc_main;
  while (1) {
    //print "pc='$pc'\n";
    $pc();
  } 
}

?>
