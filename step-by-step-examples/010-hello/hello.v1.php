<?php
include '../support/runtime.v1.php';

// primitive | hello| =
function lbl_1() {
global $reg0, $reg1, $reg2, $reg3, $pc;
$reg1  = "Hello, World!\n" ;
$pc = 'lbl_2' ;
}
function lbl_2() {
global $reg0, $reg1, $reg2, $reg3, $pc;
$pc = 'glo_display' ;
}

exec_scheme_code('lbl_1');
?>
