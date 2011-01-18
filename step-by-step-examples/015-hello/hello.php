<?php
include '../support/runtime.v1.php';

// primitive x20hello =
function glo_x20hello() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$stack[$fp+1] = $reg0;
$reg1 = "Hello, World!";
$reg0 = 'lbl_x20hello_3';
$pc = 'lbl_x20hello_2';
$fp = $fp+4;
}
function lbl_x20hello_2() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$pc = GLO_display;
}
function lbl_x20hello_3() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg0 = 'lbl_x20hello_4';
$pc = GLO_newline;
}
function lbl_x20hello_4() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg1 = "Hello, World!";
$reg0 = 'lbl_x20hello_5';
$pc = GLO_display;
}
function lbl_x20hello_5() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg0 = $stack[$fp-3];
$pc = 'lbl_x20hello_6';
}
function lbl_x20hello_6() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$pc = GLO_newline;
$fp = $fp-4;
}

exec_scheme_code('glo_x20hello');
?>
