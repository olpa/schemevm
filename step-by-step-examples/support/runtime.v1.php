<?php

define('DEBUG', TRUE);

function glo_exit() {
  global $fp, $stack;
  if (DEBUG) {
    print "\n\nProgram ended, fp=$fp, stack=$stack\n";
  }
  exit();
}

function glo_display() {
  global $reg0, $reg1, $pc;
  print $reg1;
  $pc = $reg0;
}

function glo_newline() {
  global $reg0, $pc;
  print "\n";
  $pc = $reg0;
}

function exec_scheme_code($pc_main) {
  global $pc, $reg0, $stack, $fp;
  $stack = array();
  $fp    = 0;
  $reg0  = 'glo_exit';
  $pc    = $pc_main;
  while (1) { // at some moment, glo_exit performs exit()
    //print "pc='$pc'\n";
    $pc();
  }
}

?>
