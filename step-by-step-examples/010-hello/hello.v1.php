<?php
include '../support/runtime.v1.php';

// primitive | hello| =
function lbl_1() {
$reg1  = "Hello, World!\n" ;
$pc = $lbl_2 ;
}
$lbl_1='lbl_1';
function lbl_2() {
$pc = $glo_display ;
}
$lbl_2='lbl_2';

exec_scheme_code($lbl_1);
?>
