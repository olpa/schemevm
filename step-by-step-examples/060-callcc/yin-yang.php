<?php
include '../support/runtime.v1.php';

// primitive x20yinx2dyang =
function glo_x20yinx2dyang() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp+1] = $reg0;
$reg1 = 'lbl_x20yinx2dyang_8';
$reg0 = 'lbl_x20yinx2dyang_3';
$pc = 'lbl_x20yinx2dyang_2';
$fp = $fp+4;
}
function lbl_x20yinx2dyang_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = $GLOBALS['glo_call-with-current-continuation'];
}
function lbl_x20yinx2dyang_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp-2] = $reg1;
$reg1 = '@';
$reg0 = 'lbl_x20yinx2dyang_4';
$nargs = 1;
$pc = $GLOBALS['glo_display'];
$fp = $fp+4;
}
function lbl_x20yinx2dyang_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = 'lbl_x20yinx2dyang_8';
$reg0 = 'lbl_x20yinx2dyang_5';
$nargs = 1;
$pc = $GLOBALS['glo_call-with-current-continuation'];
}
function lbl_x20yinx2dyang_5() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp-5] = $reg1;
$reg1 = '*';
$reg0 = 'lbl_x20yinx2dyang_6';
$nargs = 1;
$pc = $GLOBALS['glo_display'];
}
function lbl_x20yinx2dyang_6() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = $stack[$fp-5];
$reg0 = $stack[$fp-7];
$pc = 'lbl_x20yinx2dyang_7';
}
function lbl_x20yinx2dyang_7() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = $stack[$fp-6];
$fp = $fp-8;
}
function lbl_x20yinx2dyang_8() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$pc = $reg0;
}

exec_scheme_code('glo_x20yinx2dyang');
?>
