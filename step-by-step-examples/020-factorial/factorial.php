<?php
include '../support/runtime.v1.php';

// primitive x20factorial =
function lbl_x20factorial_1() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
#'glo_fact'  = 'glo_fact' ; # FIXME
$stack[$fp+1]  = $reg0 ;
$reg1  = 5 ;
$reg0  = 'lbl_x20factorial_3' ;
$pc = 'lbl_x20factorial_2' ;
$fp = $fp+4;
}
function lbl_x20factorial_2() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$pc = 'glo_fact' ;
}
function lbl_x20factorial_3() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg0  = 'lbl_x20factorial_4' ;
$pc = 'glo_display' ;
}
function lbl_x20factorial_4() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg0  = $stack[$fp-3] ;
$pc = 'lbl_x20factorial_5' ;
}
function lbl_x20factorial_5() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$pc = 'glo_newline' ;
$fp = $fp-4;
}
// procedure fact =
function glo_fact() { lbl_fact_1(); } # FIXME
function lbl_fact_1() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$stack[$fp+1]  = $reg0 ;
$stack[$fp+2]  = $reg1 ;
$reg0  = 'lbl_fact_3' ;
$pc = 'lbl_fact_2' ;
$fp = $fp+8;
}
function lbl_fact_2() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$pc = 'glo_zerox3f' ;
}
function lbl_fact_3() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$f='glo_x23x23not';
if($f($reg1 )) { $pc='lbl_fact_6'; } else { $pc='lbl_fact_4'; } # FIXME
}
function lbl_fact_4() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg1  = 1 ;
$pc = 'lbl_fact_5' ;
}
function lbl_fact_5() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$pc = $stack[$fp-7] ;
$fp = $fp-8;
}
function lbl_fact_6() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg1  = $stack[$fp-6] ;
$reg2  = 1 ;
$reg0  = 'lbl_fact_7' ;
$pc = 'glo_x2d' ;
}
function lbl_fact_7() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg0  = 'lbl_fact_8' ;
$pc = 'glo_fact' ;
}
function lbl_fact_8() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$reg2  = $stack[$fp-6] ;
$reg0  = $stack[$fp-7] ;
$pc = 'lbl_fact_9' ;
}
function lbl_fact_9() {
global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;
$pc = 'glo_x2a' ;
$fp = $fp-8;
}

exec_scheme_code('lbl_x20factorial_1');
?>
