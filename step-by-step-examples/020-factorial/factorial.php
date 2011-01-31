<?php
include '../support/runtime.v1.php';

// primitive x20factorial =
function glo_x20factorial() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$GLOBALS['glo_fact'] = 'glo_fact';
$stack[$fp+1] = $reg0;
$reg1 = 5;
$reg0 = 'lbl_x20factorial_3';
$pc = 'lbl_x20factorial_2';
$fp = $fp+4;
}
function lbl_x20factorial_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = $GLOBALS['glo_fact'];
}
function lbl_x20factorial_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = 'lbl_x20factorial_4';
$nargs = 1;
$pc = 'glo_display';
}
function lbl_x20factorial_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = $stack[$fp-3];
$pc = 'lbl_x20factorial_5';
}
function lbl_x20factorial_5() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 0;
$pc = 'glo_newline';
$fp = $fp-4;
}
// procedure fact =
function glo_fact() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp+1] = $reg0;
$stack[$fp+2] = $reg1;
$reg0 = 'lbl_fact_3';
$pc = 'lbl_fact_2';
$fp = $fp+8;
}
function lbl_fact_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = 'glo_zerox3f';
}
function lbl_fact_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$f='glo_x23x23not';
if($f($reg1)) { $pc='lbl_fact_6'; } else { $pc='lbl_fact_4'; }
}
function lbl_fact_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = 1;
$pc = 'lbl_fact_5';
}
function lbl_fact_5() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$pc = $stack[$fp-7];
$fp = $fp-8;
}
function lbl_fact_6() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = $stack[$fp-6];
$reg2 = 1;
$reg0 = 'lbl_fact_7';
$nargs = 2;
$pc = 'glo_x2d';
}
function lbl_fact_7() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = 'lbl_fact_8';
$nargs = 1;
$pc = $GLOBALS['glo_fact'];
}
function lbl_fact_8() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg2 = $stack[$fp-6];
$reg0 = $stack[$fp-7];
$pc = 'lbl_fact_9';
}
function lbl_fact_9() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 2;
$pc = 'glo_x2a';
$fp = $fp-8;
}

exec_scheme_code('glo_x20factorial');
?>
