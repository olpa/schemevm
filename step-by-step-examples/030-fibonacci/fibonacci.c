#ifdef ___LINKER_INFO
; File: "fibonacci.c", produced by Gambit-C v4.5.3
(
405003
" fibonacci.o3"
(" fibonacci.o3")
(
)
(
)
(
" fibonacci.o3"
"~#fib"
)
(
)
(
"display"
"newline"
)
 #f
)
#else
#define ___VERSION 405003
#define ___MODULE_NAME " fibonacci.o3"
#define ___LINKER_ID ____20_fibonacci_2e_o3
#define ___MH_PROC ___H__20_fibonacci_2e_o3
#define ___SCRIPT_LINE 0
#define ___GLO_COUNT 4
#define ___SUP_COUNT 2
#define ___LBL_COUNT 12
#include "gambit.h"

___NEED_GLO(___G__20_fibonacci_2e_o3)
___NEED_GLO(___G_display)
___NEED_GLO(___G_newline)
___NEED_GLO(___G__7e__23_fib)

___BEGIN_GLO
___DEF_GLO(0," fibonacci.o3")
___DEF_GLO(1,"~#fib")
___DEF_GLO(2,"display")
___DEF_GLO(3,"newline")
___END_GLO


#undef ___MD_ALL
#define ___MD_ALL ___D_FP ___D_R0 ___D_R1 ___D_R4
#undef ___MR_ALL
#define ___MR_ALL ___R_FP ___R_R0 ___R_R1 ___R_R4
#undef ___MW_ALL
#define ___MW_ALL ___W_FP ___W_R0 ___W_R1 ___W_R4
___BEGIN_M_COD
___BEGIN_M_HLBL
___DEF_M_HLBL_INTRO
___DEF_M_HLBL(___L0__20_fibonacci_2e_o3)
___DEF_M_HLBL(___L1__20_fibonacci_2e_o3)
___DEF_M_HLBL(___L2__20_fibonacci_2e_o3)
___DEF_M_HLBL(___L3__20_fibonacci_2e_o3)
___DEF_M_HLBL(___L4__20_fibonacci_2e_o3)
___DEF_M_HLBL_INTRO
___DEF_M_HLBL(___L0__7e__23_fib)
___DEF_M_HLBL(___L1__7e__23_fib)
___DEF_M_HLBL(___L2__7e__23_fib)
___DEF_M_HLBL(___L3__7e__23_fib)
___DEF_M_HLBL(___L4__7e__23_fib)
___END_M_HLBL

___BEGIN_M_SW

#undef ___PH_PROC
#define ___PH_PROC ___H__20_fibonacci_2e_o3
#undef ___PH_LBL0
#define ___PH_LBL0 1
#undef ___PD_ALL
#define ___PD_ALL ___D_FP ___D_R0 ___D_R1 ___D_R4
#undef ___PR_ALL
#define ___PR_ALL ___R_FP ___R_R0 ___R_R1 ___R_R4
#undef ___PW_ALL
#define ___PW_ALL ___W_FP ___W_R0 ___W_R1 ___W_R4
___BEGIN_P_COD
___BEGIN_P_HLBL
___DEF_P_HLBL_INTRO
___DEF_P_HLBL(___L0__20_fibonacci_2e_o3)
___DEF_P_HLBL(___L1__20_fibonacci_2e_o3)
___DEF_P_HLBL(___L2__20_fibonacci_2e_o3)
___DEF_P_HLBL(___L3__20_fibonacci_2e_o3)
___DEF_P_HLBL(___L4__20_fibonacci_2e_o3)
___END_P_HLBL
___BEGIN_P_SW
___DEF_SLBL(0,___L0__20_fibonacci_2e_o3)
   ___IF_NARGS_EQ(0,___NOTHING)
   ___WRONG_NARGS(0,0,0,0)
___DEF_GLBL(___L__20_fibonacci_2e_o3)
   ___SET_GLO(1,___G__7e__23_fib,___PRC(7))
   ___SET_STK(1,___R0)
   ___SET_R1(___FIX(15L))
   ___SET_R0(___LBL(2))
   ___ADJFP(4)
   ___POLL(1)
___DEF_SLBL(1,___L1__20_fibonacci_2e_o3)
   ___JUMPGLONOTSAFE(___SET_NARGS(1),1,___G__7e__23_fib)
___DEF_SLBL(2,___L2__20_fibonacci_2e_o3)
   ___SET_R0(___LBL(3))
   ___JUMPPRM(___SET_NARGS(1),___PRM(2,___G_display))
___DEF_SLBL(3,___L3__20_fibonacci_2e_o3)
   ___SET_R0(___STK(-3))
   ___POLL(4)
___DEF_SLBL(4,___L4__20_fibonacci_2e_o3)
   ___ADJFP(-4)
   ___JUMPPRM(___SET_NARGS(0),___PRM(3,___G_newline))
___END_P_SW
___END_P_COD

#undef ___PH_PROC
#define ___PH_PROC ___H__7e__23_fib
#undef ___PH_LBL0
#define ___PH_LBL0 7
#undef ___PD_ALL
#define ___PD_ALL ___D_FP ___D_R0 ___D_R1 ___D_R4
#undef ___PR_ALL
#define ___PR_ALL ___R_FP ___R_R0 ___R_R1 ___R_R4
#undef ___PW_ALL
#define ___PW_ALL ___W_FP ___W_R0 ___W_R1 ___W_R4
___BEGIN_P_COD
___BEGIN_P_HLBL
___DEF_P_HLBL_INTRO
___DEF_P_HLBL(___L0__7e__23_fib)
___DEF_P_HLBL(___L1__7e__23_fib)
___DEF_P_HLBL(___L2__7e__23_fib)
___DEF_P_HLBL(___L3__7e__23_fib)
___DEF_P_HLBL(___L4__7e__23_fib)
___END_P_HLBL
___BEGIN_P_SW
___DEF_SLBL(0,___L0__7e__23_fib)
   ___IF_NARGS_EQ(1,___NOTHING)
   ___WRONG_NARGS(0,1,0,0)
___DEF_GLBL(___L__7e__23_fib)
   ___IF(___FIXLT(___R1,___FIX(3L)))
   ___GOTO(___L5__7e__23_fib)
   ___END_IF
   ___SET_STK(1,___R0)
   ___SET_STK(2,___R1)
   ___SET_R1(___FIXSUB(___R1,___FIX(1L)))
   ___SET_R0(___LBL(2))
   ___ADJFP(4)
   ___POLL(1)
___DEF_SLBL(1,___L1__7e__23_fib)
   ___JUMPGLONOTSAFE(___SET_NARGS(1),1,___G__7e__23_fib)
___DEF_SLBL(2,___L2__7e__23_fib)
   ___SET_STK(-1,___R1)
   ___SET_R1(___FIXSUB(___STK(-2),___FIX(2L)))
   ___SET_R0(___LBL(3))
   ___JUMPGLONOTSAFE(___SET_NARGS(1),1,___G__7e__23_fib)
___DEF_SLBL(3,___L3__7e__23_fib)
   ___SET_R1(___FIXADD(___STK(-1),___R1))
   ___POLL(4)
___DEF_SLBL(4,___L4__7e__23_fib)
   ___ADJFP(-4)
   ___JUMPPRM(___NOTHING,___STK(1))
___DEF_GLBL(___L5__7e__23_fib)
   ___SET_R1(___FIX(1L))
   ___JUMPPRM(___NOTHING,___R0)
___END_P_SW
___END_P_COD

___END_M_SW
___END_M_COD

___BEGIN_LBL
 ___DEF_LBL_INTRO(___H__20_fibonacci_2e_o3," fibonacci.o3",___REF_FAL,5,0)
,___DEF_LBL_PROC(___H__20_fibonacci_2e_o3,0,0)
,___DEF_LBL_RET(___H__20_fibonacci_2e_o3,___IFD(___RETI,4,0,0x3f1L))
,___DEF_LBL_RET(___H__20_fibonacci_2e_o3,___IFD(___RETN,3,0,0x1L))
,___DEF_LBL_RET(___H__20_fibonacci_2e_o3,___IFD(___RETN,3,0,0x1L))
,___DEF_LBL_RET(___H__20_fibonacci_2e_o3,___IFD(___RETI,4,4,0x3f0L))
,___DEF_LBL_INTRO(___H__7e__23_fib,0,___REF_FAL,5,0)
,___DEF_LBL_PROC(___H__7e__23_fib,1,0)
,___DEF_LBL_RET(___H__7e__23_fib,___IFD(___RETI,4,0,0x3f3L))
,___DEF_LBL_RET(___H__7e__23_fib,___IFD(___RETN,3,0,0x3L))
,___DEF_LBL_RET(___H__7e__23_fib,___IFD(___RETN,3,0,0x5L))
,___DEF_LBL_RET(___H__7e__23_fib,___IFD(___RETI,4,0,0x3f1L))
___END_LBL

___BEGIN_MOD1
___DEF_PRM(0,___G__20_fibonacci_2e_o3,1)
___END_MOD1

___BEGIN_MOD2
___END_MOD2

#endif
