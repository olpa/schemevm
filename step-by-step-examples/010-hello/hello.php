<?php
include '../support/runtime.v1.php';

// primitive x20hello =
function glo_x20hello() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = "Hello, World!\n";
$pc = 'lbl_x20hello_2';
}
function lbl_x20hello_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = $GLOBALS['glo_display'];
}

exec_scheme_code('glo_x20hello');
?>
