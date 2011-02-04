<?php
include '../support/runtime.v1.php';

// primitive x20return =
function glo_x20return() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$GLOBALS['glo_f'] = 'glo_f';
$stack[$fp+1] = $reg0;
$reg1 = 'lbl_x20return_9';
$reg0 = 'lbl_x20return_3';
$pc = 'lbl_x20return_2';
$fp = $fp+4;
}
function lbl_x20return_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = $GLOBALS['glo_f'];
}
function lbl_x20return_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = 'lbl_x20return_4';
$nargs = 1;
$pc = 'glo_display';
}
function lbl_x20return_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = 'lbl_x20return_5';
$nargs = 0;
$pc = 'glo_newline';
}
function lbl_x20return_5() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = $GLOBALS['glo_f'];
$reg0 = 'lbl_x20return_6';
$nargs = 1;
$pc = 'glo_callx2dwithx2dcurrentx2dcontinuation';
}
function lbl_x20return_6() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = 'lbl_x20return_7';
$nargs = 1;
$pc = 'glo_display';
}
function lbl_x20return_7() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = $stack[$fp-3];
$pc = 'lbl_x20return_8';
}
function lbl_x20return_8() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 0;
$pc = 'glo_newline';
$fp = $fp-4;
}
function lbl_x20return_9() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$pc = $reg0;
}
// procedure f =
function glo_f() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp+1] = $reg0;
$stack[$fp+2] = $reg1;
$reg1 = 2;
$reg0 = 'lbl_f_3';
$pc = 'lbl_f_2';
$fp = $fp+4;
}
function lbl_f_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = $stack[$fp-2];
}
function lbl_f_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = 3;
$pc = 'lbl_f_4';
}
function lbl_f_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$pc = $stack[$fp-3];
$fp = $fp-4;
}

exec_scheme_code('glo_x20return');
?>
