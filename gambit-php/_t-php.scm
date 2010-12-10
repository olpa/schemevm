;;;============================================================================

;;; File: "_t-univ.scm"

(include "fixnum.scm")

(include-adt "_envadt.scm")
(include-adt "_gvmadt.scm")
(include-adt "_ptreeadt.scm")
(include-adt "_sourceadt.scm")

;;;----------------------------------------------------------------------------
;;
;; "Universal" back-end.

;; Initialization/finalization of back-end.

(define (univ-setup target-language)
  (let ((targ (make-target 6 target-language)))

    (define (begin! info-port)

      (target-dump-set!
       targ
       (lambda (procs output output-root c-intf script-line options)
         (univ-dump targ procs output output-root c-intf script-line options)))

      (target-nb-regs-set! targ univ-nb-gvm-regs)

      (target-prim-info-set!
       targ
       (lambda (name)
         (univ-prim-info targ name)))

      (target-label-info-set!
       targ
       (lambda (nb-parms closed?)
         (univ-label-info targ nb-parms closed?)))

      (target-jump-info-set!
       targ
       (lambda (nb-args)
         (univ-jump-info targ nb-args)))

      (target-frame-constraints-set!
       targ
       (make-frame-constraints univ-frame-reserve univ-frame-alignment))

      (target-proc-result-set!
       targ
       (make-reg 1))

      (target-task-return-set!
       targ
       (make-reg 0))

      (target-switch-testable?-set!
       targ
       (lambda (obj)
         (univ-switch-testable? targ obj)))

      #f)

    (define (end!)
      #f)

    (target-begin!-set! targ begin!)
    (target-end!-set! targ end!)
    (target-add targ)))

(univ-setup 'php)

;;;----------------------------------------------------------------------------

;; ***** PROCEDURE CALLING CONVENTION

(define univ-nb-gvm-regs 5)
(define univ-nb-arg-regs 3)

(define (univ-label-info targ nb-parms closed?)

;; After a GVM "entry-point" or "closure-entry-point" label, the following
;; is true:
;;
;;  * return address is in GVM register 0
;;
;;  * if nb-parms <= nb-arg-regs
;;
;;      then parameter N is in GVM register N
;;
;;      else parameter N is in
;;               GVM register N-F, if N > F
;;               GVM stack slot N, if N <= F
;;           where F = nb-parms - nb-arg-regs
;;
;;  * for a "closure-entry-point" GVM register nb-arg-regs+1 contains
;;    a pointer to the closure object
;;
;;  * other GVM registers contain an unspecified value

  (let ((nb-stacked (max 0 (- nb-parms univ-nb-arg-regs))))

    (define (location-of-parms i)
      (if (> i nb-parms)
          '()
          (cons (cons i
                      (if (> i nb-stacked)
                          (make-reg (- i nb-stacked))
                          (make-stk i)))
                (location-of-parms (+ i 1)))))

    (let ((x (cons (cons 'return 0) (location-of-parms 1))))
      (make-pcontext nb-stacked
                     (if closed?
                         (cons (cons 'closure-env
                                     (make-reg (+ univ-nb-arg-regs 1)))
                               x)
                         x)))))

(define (univ-jump-info targ nb-args)

;; After a GVM "jump" instruction with argument count, the following
;; is true:
;;
;;  * the return address is in GVM register 0
;;
;;  * if nb-args <= nb-arg-regs
;;
;;      then argument N is in GVM register N
;;
;;      else argument N is in
;;               GVM register N-F, if N > F
;;               GVM stack slot N, if N <= F
;;           where F = nb-args - nb-arg-regs
;;
;;  * GVM register nb-arg-regs+1 contains a pointer to the closure object
;;    if a closure is being jumped to
;;
;;  * other GVM registers contain an unspecified value

  (let ((nb-stacked (max 0 (- nb-args univ-nb-arg-regs))))

    (define (location-of-args i)
      (if (> i nb-args)
          '()
          (cons (cons i
                      (if (> i nb-stacked)
                          (make-reg (- i nb-stacked))
                          (make-stk i)))
                (location-of-args (+ i 1)))))

    (make-pcontext nb-stacked
                   (cons (cons 'return (make-reg 0))
                         (location-of-args 1)))))

;; The frame constraints are defined by the parameters
;; univ-frame-reserve and univ-frame-alignment.

(define univ-frame-reserve 3) ;; when the stack frame is transformed to a
                              ;; heap frame, 3 extra slots are needed to
                              ;; store the subtype object header, the link
                              ;; to the next frame and the return address.

(define univ-frame-alignment 4) ;; align frame to multiple of 4 slots

;; ***** PRIMITIVE PROCEDURE DATABASE

(define (univ-prim-info targ name)
  (table-ref univ-prim-proc-table name #f))

(define univ-prim-proc-table (make-table))

(define (univ-prim-proc-add! x)
  (let ((sym (string->canonical-symbol (car x))))
    (table-set! univ-prim-proc-table
                sym
                (apply make-proc-obj (car x) #f #t #f (cdr x)))))

(for-each univ-prim-proc-add! prim-procs)

(define (univ-switch-testable? targ obj)
  (pretty-print (list 'univ-switch-testable? 'targ obj))
  #f)

;; ***** DUMPING OF A COMPILATION MODULE

(define (univ-dump targ procs output output-root c-intf script-line options)
  (case (target-name targ)
    ((php)
     (php-dump targ procs output output-root c-intf script-line options))
    (else
     (error "Unsupported target language" (target-name targ)))))

(define port)

(define (php-dump targ procs output output-root c-intf script-line options)
  ;(virtual.dump procs (current-output-port)) ;; just dump the GVM code for now
  ;(for-each (lambda (proc) (scan-opnd (make-obj proc))) procs)
  (set! port (current-output-port))
  (display "<?php\ninclude '../support/runtime.v1.php';\n\n")
  (for-each php-dump-proc procs)
  (display "\nexec_scheme_code($lbl_1);\n?>\n")
  #f)

(define (php-dump-proc proc)
  (if (proc-obj-primitive? proc)
    (display "// primitive ")
    (display "// procedure "))
  (write (string->canonical-symbol (proc-obj-name proc)))
  (display " =")
  (newline port)

  (let ((x (proc-obj-code proc)))
    (if (bbs? x)
      (php-dump-bbs x)
      (display "No, not a bbs\n")))
  )

(define (php-dump-bbs bbs)
  (bbs-for-each-bb php-dump-bb bbs))

(define (php-dump-bb bb)
  (php-dump-instr-label (bb-label-instr bb))
  (for-each php-dump-instr (bb-non-branch-instrs bb))
  (php-dump-instr (bb-branch-instr bb))
  (php-dump-instr-label-close (bb-label-instr bb))
  )

(define (php-dump-instr instr)
  ((case (gvm-instr-type instr)
     ((label) php-dump-instr-label)
     ((copy)  php-dump-instr-copy)
     ((jump)  php-dump-instr-jump)
     (else    php-dump-instr-unknown))  instr)
  )

(define (php-dump-instr-unknown instr)
  (display "unknown instruction of type: ")
  (display (gvm-instr-type instr))
  (newline))

(define (php-dump-instr-label instr)
  (display "function lbl_")
  (display (label-lbl-num instr))
  (display "() {\n")
  )

(define (php-dump-instr-label-close instr)
  (let ([lbl-num (label-lbl-num instr)])
    (display "}\n$lbl_")
    (display lbl-num)
    (display "='lbl_")
    (display lbl-num)
    (display "';\n")
  ))

(define (php-dump-instr-copy instr)
  (php-dump-loc (copy-loc instr))
  (display " = ")
  (php-dump-loc (copy-opnd instr))
  (display ";\n"))

(define (php-dump-loc loc)
  (cond
    ((reg? loc) (display "$reg")(display (reg-num loc)))
    ((obj? loc) (php-dump-scheme-object (obj-val loc)))
    ((glo? loc) (display "$glo_")(display (glo-name loc)))
    ((lbl? loc) (display "$lbl_")(display (lbl-num loc)))
    (else       (display "loc#")(display loc)))
  (display " "))

(define (php-dump-scheme-object obj)
  (write obj))

(define (php-dump-instr-jump instr)
  (display "$pc = ")
  (php-dump-loc (jump-opnd instr))
  (display ";\n"))

;;;============================================================================
