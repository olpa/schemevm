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

; The argument "procs" of "univ-dump" does not contain all the
; procedures. Instead, some of them are connected to arguments
; of GVM instructions. In other words, while generating code for
; a procedure we can find one more procedure, and generate code
; for it later.
(define proc-seen (queue-empty))
(define proc-left (queue-empty))
(define (scan-obj obj)

  (if (and (proc-obj? obj)
           (proc-obj-code obj)
           (not (memq obj (queue->list proc-seen))))
    (begin
      (queue-put! proc-seen obj)
      (queue-put! proc-left obj))))

(define (php-dump targ procs output output-root c-intf script-line options)
  ;(virtual.dump procs (current-output-port)) ;; just dump the GVM code for now
  ;(for-each (lambda (proc) (scan-opnd (make-obj proc))) procs)
  (set! port (current-output-port))
  (display "<?php\ninclude '../support/runtime.v1.php';\n\n")
  (for-each (lambda (proc) (scan-obj proc)) procs)
  (let loop ()
    (if (not (queue-empty? proc-left))
      (begin
        (display "!?!? ========== !!?!?!?!?!\n")
        (php-dump-proc (queue-get! proc-left))
        (loop))))
  (display "\nexec_scheme_code('lbl_1');\n?>\n")
  ;(find-all-the-code procs)
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
  (bbs-for-each-bb (get-php-dump-bb) bbs))

(define (get-php-dump-bb)
  (let ([fp-offset 0])
    (lambda (bb)
      (php-dump-instr-label (bb-label-instr bb))
      (display "global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;\n")
      (for-each
        (lambda (bb) (php-dump-instr bb fp-offset))
        (bb-non-branch-instrs bb))
      (php-dump-instr (bb-branch-instr bb) fp-offset)
      (let ([frame-size-delta
              (- (frame-size (gvm-instr-frame (bb-branch-instr bb)))
                 (frame-size (gvm-instr-frame (bb-label-instr bb))))])
        (if (not (= 0 frame-size-delta))
          (begin
            (display "$fp = $fp")
            (display-with-plus-or-minus frame-size-delta)
            (display ";\n")
            (set! fp-offset (+ fp-offset frame-size-delta)))))
      (php-dump-instr-label-close (bb-label-instr bb))
  ))
)

(define (display-with-plus-or-minus num)
  (if (< num 0)
    (display num)
    (begin (display "+")(display num))))

(define (php-dump-instr instr fp-offset)
  (let ([instr-type (gvm-instr-type instr)])
    (cond
      ((eq? instr-type 'label) (php-dump-instr-label   instr))
      ((eq? instr-type 'copy)  (php-dump-instr-copy    instr fp-offset))
      ((eq? instr-type 'jump)  (php-dump-instr-jump    instr fp-offset))
      (else                    (php-dump-instr-unknown instr)))))

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
    (display "}\n")
  ))

(define (php-dump-instr-copy instr fp-offset)
  (let ([copy-opnd (copy-opnd instr)])
    (if copy-opnd
      (begin
        (php-dump-loc (copy-loc instr) fp-offset)
        (display " = ")
        (php-dump-loc copy-opnd fp-offset)
        (display ";\n")))))

(define (php-dump-loc loc fp-offset)
  (cond
    ((reg? loc) (display "$reg")(display (reg-num loc)))
    ((stk? loc) (display "$stack[$fp")
                (display-with-plus-or-minus (- (stk-num loc) fp-offset))
                (display "]"))
    ((obj? loc) (php-dump-scheme-object (obj-val loc)))
    ((glo? loc) (display "'glo_")(display (glo-name loc))(display "'"))
    ((lbl? loc) (display "'lbl_")(display (lbl-num loc))(display "'"))
    (else       (display "loc#")(display loc)))
  (display " "))

(define (php-dump-scheme-object obj)
  (if (proc-obj? obj)
    (begin (display "'glo_")(display (proc-obj-name obj))(display "'")
           (scan-obj obj)
           )
    (write obj)))

(define (php-dump-instr-jump instr fp-offset)
  (display "$pc = ")
  (php-dump-loc (jump-opnd instr) fp-offset)
  (display ";\n"))

;;;============================================================================
