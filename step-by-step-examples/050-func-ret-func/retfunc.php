<?php
include '../support/runtime.v1.php';

// primitive x20retfunc =
function glo_x20retfunc() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$GLOBALS['glo_mkadder'] = 'glo_mkadder';
$stack[$fp+1] = $reg0;
$reg1 = 1;
$reg0 = 'lbl_x20retfunc_3';
$pc = 'lbl_x20retfunc_2';
$fp = $fp+4;
}
function lbl_x20retfunc_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = $GLOBALS['glo_mkadder'];
}
function lbl_x20retfunc_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp-2] = $reg1;
$reg1 = 2;
$reg0 = 'lbl_x20retfunc_4';
$nargs = 1;
$pc = $stack[$fp-2];
}
function lbl_x20retfunc_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp-2] = $reg1;
$reg1 = 3;
$reg0 = 'lbl_x20retfunc_5';
$nargs = 1;
$pc = $stack[$fp-2];
}
function lbl_x20retfunc_5() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$GLOBALS['glo_xadder'] = $reg1;
$reg1 = 4;
$reg0 = 'lbl_x20retfunc_6';
$nargs = 1;
$pc = $GLOBALS['glo_xadder'];
}
function lbl_x20retfunc_6() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = 'lbl_x20retfunc_7';
$nargs = 1;
$pc = 'glo_display';
}
function lbl_x20retfunc_7() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = $stack[$fp-3];
$pc = 'lbl_x20retfunc_8';
}
function lbl_x20retfunc_8() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 0;
$pc = 'glo_newline';
$fp = $fp-4;
}
// procedure mkadder =
function glo_mkadder() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp+1] = array('lbl_mkadder_2', $reg1);
$reg1 = $stack[$fp+1];
$pc = $reg0;
}
function lbl_mkadder_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp+1] = array('lbl_mkadder_3', $reg4[1], $reg1);
$reg1 = $stack[$fp+1];
$pc = $reg0;
}
function lbl_mkadder_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp+1] = array('lbl_mkadder_4', $reg4[1], $reg4[2], $reg1);
$reg1 = $stack[$fp+1];
$pc = $reg0;
}
function lbl_mkadder_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp+1] = $reg4[1];
$reg3 = $reg1;
$reg2 = $reg4[3];
$reg1 = $reg4[2];
$pc = 'lbl_mkadder_5';
$fp = $fp+1;
}
function lbl_mkadder_5() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 4;
$pc = 'glo_x2b';
}

exec_scheme_code('glo_x20retfunc');
?>
