<?php
include '../support/runtime.v1.php';

// primitive x20ackermann =
function glo_x20ackermann() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$GLOBALS['glo_ack'] = 'glo_ack';
$stack[$fp+1] = $reg0;
$reg2 = 9;
$reg1 = 3;
$reg0 = 'lbl_x20ackermann_3';
$pc = 'lbl_x20ackermann_2';
$fp = $fp+4;
}
function lbl_x20ackermann_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 2;
$pc = $GLOBALS['glo_ack'];
}
function lbl_x20ackermann_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = 'lbl_x20ackermann_4';
$nargs = 1;
$pc = 'glo_display';
}
function lbl_x20ackermann_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = $stack[$fp-3];
$pc = 'lbl_x20ackermann_5';
}
function lbl_x20ackermann_5() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 0;
$pc = 'glo_newline';
$fp = $fp-4;
}
// procedure ack =
function glo_ack() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp+1] = $reg0;
$stack[$fp+2] = $reg1;
$stack[$fp+3] = $reg2;
$reg2 = 0;
$reg0 = 'lbl_ack_3';
$pc = 'lbl_ack_2';
$fp = $fp+8;
}
function lbl_ack_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 2;
$pc = 'glo_x3d';
}
function lbl_ack_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$f='glo_x23x23not';
if($f($reg1)) { $pc='lbl_ack_6'; } else { $pc='lbl_ack_4'; }
}
function lbl_ack_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = $stack[$fp-5];
$reg2 = 1;
$reg0 = $stack[$fp-7];
$pc = 'lbl_ack_5';
}
function lbl_ack_5() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 2;
$pc = 'glo_x2b';
$fp = $fp-8;
}
function lbl_ack_6() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = $stack[$fp-5];
$reg2 = 0;
$reg0 = 'lbl_ack_7';
$nargs = 2;
$pc = 'glo_x3d';
}
function lbl_ack_7() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$f='glo_x23x23not';
if($f($reg1)) { $pc='lbl_ack_8'; } else { $pc='lbl_ack_13'; }
}
function lbl_ack_8() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = $stack[$fp-6];
$reg2 = 1;
$reg0 = 'lbl_ack_9';
$nargs = 2;
$pc = 'glo_x2d';
}
function lbl_ack_9() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp-4] = $reg1;
$reg1 = $stack[$fp-5];
$reg2 = 1;
$reg0 = 'lbl_ack_10';
$nargs = 2;
$pc = 'glo_x2d';
}
function lbl_ack_10() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg2 = $reg1;
$reg1 = $stack[$fp-6];
$reg0 = 'lbl_ack_11';
$nargs = 2;
$pc = $GLOBALS['glo_ack'];
}
function lbl_ack_11() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg2 = $reg1;
$reg0 = $stack[$fp-7];
$reg1 = $stack[$fp-4];
$pc = 'lbl_ack_12';
}
function lbl_ack_12() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 2;
$pc = $GLOBALS['glo_ack'];
$fp = $fp-8;
}
function lbl_ack_13() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = $stack[$fp-6];
$reg2 = 1;
$reg0 = 'lbl_ack_14';
$nargs = 2;
$pc = 'glo_x2d';
$fp = $fp-4;
}
function lbl_ack_14() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg2 = 1;
$reg0 = $stack[$fp-3];
$pc = 'lbl_ack_15';
}
function lbl_ack_15() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 2;
$pc = $GLOBALS['glo_ack'];
$fp = $fp-4;
}

exec_scheme_code('glo_x20ackermann');
?>
