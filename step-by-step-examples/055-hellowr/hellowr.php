<?php
include '../support/runtime.v1.php';

// primitive x20hellowr =
function glo_x20hellowr() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$GLOBALS['glo_сделать-писалку'] = 'glo_xd1x81xd0xb4xd0xb5xd0xbbxd0xb0xd1x82xd1x8cx2dxd0xbfxd0xb8xd1x81xd0xb0xd0xbbxd0xbaxd1x83';
$stack[$fp+1] = $reg0;
$reg1 = "\320\237\321\200\320\270\320\262\320\265\321\202!\n";
$reg0 = 'lbl_x20hellowr_3';
$pc = 'lbl_x20hellowr_2';
$fp = $fp+4;
}
function lbl_x20hellowr_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = $GLOBALS['glo_сделать-писалку'];
}
function lbl_x20hellowr_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$GLOBALS['glo_пиши-привет'] = $reg1;
$reg0 = $stack[$fp-3];
$pc = 'lbl_x20hellowr_4';
}
function lbl_x20hellowr_4() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 0;
$pc = $GLOBALS['glo_пиши-привет'];
$fp = $fp-4;
}
// procedure xd1x81xd0xb4xd0xb5xd0xbbxd0xb0xd1x82xd1x8cx2dxd0xbfxd0xb8xd1x81xd0xb0xd0xbbxd0xbaxd1x83 =
function glo_xd1x81xd0xb4xd0xb5xd0xbbxd0xb0xd1x82xd1x8cx2dxd0xbfxd0xb8xd1x81xd0xb0xd0xbbxd0xbaxd1x83() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$stack[$fp+1] = array('lbl_xd1x81xd0xb4xd0xb5xd0xbbxd0xb0xd1x82xd1x8cx2dxd0xbfxd0xb8xd1x81xd0xb0xd0xbbxd0xbaxd1x83_2', $reg1);
$reg1 = $stack[$fp+1];
$pc = $reg0;
}
function lbl_xd1x81xd0xb4xd0xb5xd0xbbxd0xb0xd1x82xd1x8cx2dxd0xbfxd0xb8xd1x81xd0xb0xd0xbbxd0xbaxd1x83_2() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$reg1 = $reg4[1];
$pc = 'lbl_xd1x81xd0xb4xd0xb5xd0xbbxd0xb0xd1x82xd1x8cx2dxd0xbfxd0xb8xd1x81xd0xb0xd0xbbxd0xbaxd1x83_3';
}
function lbl_xd1x81xd0xb4xd0xb5xd0xbbxd0xb0xd1x82xd1x8cx2dxd0xbfxd0xb8xd1x81xd0xb0xd0xbbxd0xbaxd1x83_3() {
global $reg0, $reg1, $reg2, $reg3, $reg4, $pc, $fp, $stack, $nargs;
$nargs = 1;
$pc = $GLOBALS['glo_display'];
}

exec_scheme_code('glo_x20hellowr');
?>
