<?php
include '../support/runtime.v1.php';

// primitive x20fibonacci =
function glo_x20fibonacci() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$GLOBALS['glo_fib'] = 'glo_fib';
$stack[$fp+1] = $reg0;
$reg1 = 15;
$reg0 = 'lbl_x20fibonacci_3';
$pc = 'lbl_x20fibonacci_2';
$fp = $fp+4;
}
function lbl_x20fibonacci_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = $GLOBALS['glo_fib'];
}
function lbl_x20fibonacci_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = 'lbl_x20fibonacci_4';
$nargs = 1;
$pc = 'glo_display';
}
function lbl_x20fibonacci_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = $stack[$fp-3];
$pc = 'lbl_x20fibonacci_5';
}
function lbl_x20fibonacci_5() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 0;
$pc = 'glo_newline';
$fp = $fp-4;
}
// procedure fib =
function glo_fib() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp+1] = $reg0;
$stack[$fp+2] = $reg1;
$reg2 = 3;
$reg0 = 'lbl_fib_3';
$pc = 'lbl_fib_2';
$fp = $fp+8;
}
function lbl_fib_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 2;
$pc = 'glo_x3c';
}
function lbl_fib_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$f='glo_x23x23not';
if($f($reg1)) { $pc='lbl_fib_6'; } else { $pc='lbl_fib_4'; }
}
function lbl_fib_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = 1;
$pc = 'lbl_fib_5';
}
function lbl_fib_5() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$pc = $stack[$fp-7];
$fp = $fp-8;
}
function lbl_fib_6() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = $stack[$fp-6];
$reg2 = 1;
$reg0 = 'lbl_fib_7';
$nargs = 2;
$pc = 'glo_x2d';
}
function lbl_fib_7() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = 'lbl_fib_8';
$nargs = 1;
$pc = $GLOBALS['glo_fib'];
}
function lbl_fib_8() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp-5] = $reg1;
$reg1 = $stack[$fp-6];
$reg2 = 2;
$reg0 = 'lbl_fib_9';
$nargs = 2;
$pc = 'glo_x2d';
}
function lbl_fib_9() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg0 = 'lbl_fib_10';
$nargs = 1;
$pc = $GLOBALS['glo_fib'];
}
function lbl_fib_10() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg2 = $reg1;
$reg0 = $stack[$fp-7];
$reg1 = $stack[$fp-5];
$pc = 'lbl_fib_11';
}
function lbl_fib_11() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 2;
$pc = 'glo_x2b';
$fp = $fp-8;
}

exec_scheme_code('glo_x20fibonacci');
?>
