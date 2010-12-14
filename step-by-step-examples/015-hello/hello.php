<?php
include '../support/runtime.v1.php';

// primitive | hello| =
function lbl_1() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$stack[$fp+1]  = $reg0 ;
$reg1  = "Hello, World!" ;
$reg0  = 'lbl_3' ;
$pc = 'lbl_2' ;
$fp = $fp+4;
}
function lbl_2() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$pc = 'glo_display' ;
}
function lbl_3() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg0  = 'lbl_4' ;
$pc = 'glo_newline' ;
}
function lbl_4() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg1  = "Hello, World!" ;
$reg0  = 'lbl_5' ;
$pc = 'glo_display' ;
}
function lbl_5() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg0  = $stack[$fp-3] ;
$pc = 'lbl_6' ;
}
function lbl_6() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$pc = 'glo_newline' ;
$fp = $fp-4;
}

exec_scheme_code('lbl_1');
?>
