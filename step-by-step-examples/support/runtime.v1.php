<?php

//define('DEBUG', TRUE);
define('DEBUG', FALSE);

function glo_exit() {
  global $fp, $reg1, $stack;
  if (DEBUG) {
    print "\n\nProgram ended, reg1=$reg1, fp=$fp, stack=$stack\n";
  }
  exit();
}

$GLOBALS['glo_display'] = 'glo_display';
function glo_display() {
  global $reg0, $reg1, $pc;
  print $reg1;
  $pc = $reg0;
}

$GLOBALS['glo_newline'] = 'glo_newline';
function glo_newline() {
  global $reg0, $pc;
  print "\n";
  $pc = $reg0;
}

function glo_zerox3f() { // zero?
  global $reg0, $reg1, $pc;
  $reg1 = (0 ==  $reg1);
  $pc = $reg0;
}

function glo_x23x23not($b) { // ##not: primitive
  return ! $b;
}

function glo_x2b() { // +
  global $reg0, $reg1, $reg2, $reg3, $pc, $nargs, $stack, $fp;
  if (4 == $nargs) {
    $reg1 = $reg1 + $reg2 + $reg3 + $stack[$fp+0];
    $fp   = $fp-1;
  } else {
    $reg1 = $reg1 + $reg2;
  }
  $pc = $reg0;
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

function glo_x3c() { // <
  global $reg0, $reg1, $reg2, $pc;
  $reg1 = $reg1 < $reg2;
  $pc = $reg0;
}

function glo_x3d() { // =
  global $reg0, $reg1, $reg2, $pc;
  $reg1 = $reg1 == $reg2;
  $pc = $reg0;
}

// from "The 90 Minute Scheme to C compiler"
// (define call/cc
//  (lambda (k f)
//    (f k (lambda (dummy-k result)
//           (k result)))))
$GLOBALS['glo_call-with-current-continuation'] = 'glo_callx2dwithx2dcurrentx2dcontinuation';
function glo_callx2dwithx2dcurrentx2dcontinuation() {
  global $reg0; // k
  global $reg1; // f
  global $pc, $fp, $stack;
  $pc = $reg1;
  $stack_copy = $stack; // promised to be a shallow copy
  $reg1 = array('#continuation', $reg0, $fp, $stack_copy);
}

function exec_scheme_code($pc_main) {
  global $pc, $reg0, $reg1, $reg2, $reg3, $reg4, $stack, $fp;
  $stack = array();
  $fp    = 0;
  $reg0  = 'glo_exit';
  $pc    = $pc_main;
  while (1) { // at some moment, glo_exit performs exit()
    //print "pc='$pc', fp='$fp', reg1='$reg1', reg2='$reg2'\n";flush();
    //print_r($stack);
    // closure
    if (is_array($pc)) {
      if ('#continuation' == $pc[0]) {
        $stack = $pc[3]; // Must be a copy too
        $fp = $pc[2];
        $pc = $pc[1];
      } else {
        $reg4 = $pc;
        $pc   = $pc[0];
      }
    }
    $pc();
  }
}

?>
