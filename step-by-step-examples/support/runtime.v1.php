<?php

define('DEBUG', TRUE);

function glo_exit() {
  global $fp, $reg1, $stack;
  if (DEBUG) {
    print "\n\nProgram ended, reg1=$reg1, fp=$fp, stack=$stack\n";
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

function glo_zerox3f() { // zero?
  global $reg0, $reg1, $pc;
  $reg1 = (0 ===  $reg1);
  $pc = $reg0;
}

function glo_x23x23not($b) { // ##not: primitive
  return ! $b;
}

function glo_x2d() { // -
  global $reg0, $reg1, $reg2, $pc;
  $reg1 = $reg1 - $reg2;
  $pc = $reg0;
}

function glo_x2a() { // *
  global $reg0, $reg1, $reg2, $pc;
  $reg1 = $reg1 * $reg2;
  $pc = $reg0;
}

function exec_scheme_code($pc_main) {
  global $pc, $reg0, $reg1, $reg2, $stack, $fp;
  $stack = array();
  $fp    = 0;
  $reg0  = 'glo_exit';
  $pc    = $pc_main;
  while (1) { // at some moment, glo_exit performs exit()
    //print "pc='$pc', fp='$fp', reg1='$reg1', reg2='$reg2'\n";flush();
    $pc();
  }
}

?>
