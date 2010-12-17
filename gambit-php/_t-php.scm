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

(define (proc-obj-c-name-set! obj name)
  (vector-set! obj 2 name))

; The argument "procs" of "univ-dump" does not contain all the
; procedures. Instead, some of them are connected to arguments
; of GVM instructions. In other words, while generating code for
; a procedure we can find one more procedure, and generate code
; for it later. Second side-effect: assign a C/PHP name
; to procedures (and primitives).
(define proc-seen (queue-empty))
(define proc-left (queue-empty))
(define (scan-obj obj)
  (and (proc-obj? obj)
       (not (proc-obj-c-name obj))
       (proc-obj-c-name-set! obj (mangle-name (proc-obj-name obj))))
  (if (and (proc-obj? obj)
           (proc-obj-code obj)
           (not (memq obj (queue->list proc-seen))))
    (begin
      (queue-put! proc-seen obj)
      (queue-put! proc-left obj))))

; Auxiliary information while dumping a procedure
(define (make-dump-baton proc)
  (vector proc 0))
(define (get-dump-proc baton)
  (vector-ref baton 0))
(define (get-dump-fp-offset baton)
  (vector-ref baton 1))
(define (set-dump-fp-offset! baton val)
  (vector-set! baton 1 val))

; name mangling to create valid c/php identifiers
(define (mangle-name name)
  (letrec (
      [mangle-rec (lambda (chars)
        (if (null? chars)
          '()
          (let ([ch   (car chars)]
                [rest (cdr chars)])
            (if (or (char-alphabetic? ch) (char-numeric? ch) )
              (cons ch (mangle-rec rest))
              (append '(#\x)
                      (string->list (number->string (char->integer ch) 16))
                      (mangle-rec rest))))))])
    (list->string (mangle-rec (string->list name)))))

;
; php-dump
;
(define (php-dump targ procs output output-root c-intf script-line options)
  ;(virtual.dump procs (current-output-port)) ;; just dump the GVM code for now
  (set! port (current-output-port))
  (display "<?php\ninclude '../support/runtime.v1.php';\n\n")
  (for-each (lambda (proc) (scan-obj proc)) procs)
  (let loop ()
    (if (not (queue-empty? proc-left))
      (begin
        (php-dump-proc (queue-get! proc-left))
        (loop))))
  (display "\nexec_scheme_code('")
  (php-dump-label-name 1 (make-dump-baton (car procs)))
  (display "');\n?>\n")
  #f)

(define (php-dump-proc proc)
  (if (proc-obj-primitive? proc)
    (display "// primitive ")
    (display "// procedure "))
  (write (string->canonical-symbol (proc-obj-c-name proc)))
  (display " =")
  (newline port)

  (let ((x (proc-obj-code proc)))
    (if (bbs? x)
      (php-dump-bbs x (make-dump-baton proc))
      (display "No, not a bbs\n")))
  )

(define (php-dump-bbs bbs baton)
  (bbs-for-each-bb (lambda (bb) (php-dump-bb bb baton)) bbs))

(define (php-dump-bb bb baton)
  (php-dump-instr-label (bb-label-instr bb) baton)
  (display "global $reg0, $reg1, $reg2, $reg3, $pc, $fp, $stack;\n")
  (for-each
    (lambda (bb) (php-dump-instr bb baton))
    (bb-non-branch-instrs bb))
  (php-dump-instr (bb-branch-instr bb) baton)
  (let ([frame-size-delta
          (- (frame-size (gvm-instr-frame (bb-branch-instr bb)))
             (frame-size (gvm-instr-frame (bb-label-instr bb))))])
    (if (not (= 0 frame-size-delta))
      (begin
        (display "$fp = $fp")
        (display-with-plus-or-minus frame-size-delta)
        (display ";\n")
        (set-dump-fp-offset! baton
            (+ (get-dump-fp-offset baton) frame-size-delta)))))
  (php-dump-instr-label-close (bb-label-instr bb))
)

(define (display-with-plus-or-minus num)
  (if (< num 0)
    (display num)
    (begin (display "+")(display num))))

(define (php-dump-instr instr baton)
  (let ([instr-type (gvm-instr-type instr)])
    (cond
      ((eq? instr-type 'label)  (php-dump-instr-label   instr baton))
      ((eq? instr-type 'copy)   (php-dump-instr-copy    instr baton))
      ((eq? instr-type 'jump)   (php-dump-instr-jump    instr baton))
      ((eq? instr-type 'ifjump) (php-dump-instr-ifjump  instr baton))
      (else                     (php-dump-instr-unknown instr)))))

(define (php-dump-instr-unknown instr)
  (display "unknown instruction of type: ")
  (display (gvm-instr-type instr))
  (newline))

(define (php-dump-instr-label instr baton)
  (display "function ")
  (php-dump-label-name (label-lbl-num instr) baton)
  (display "() {\n")
  )

(define (php-dump-instr-label-close instr)
  (let ([lbl-num (label-lbl-num instr)])
    (display "}\n")
  ))

(define (php-dump-instr-copy instr baton)
  (let ([copy-opnd (copy-opnd instr)])
    (if copy-opnd
      (begin
        (php-dump-loc (copy-loc instr) baton)
        (display " = ")
        (php-dump-loc copy-opnd baton)
        (display ";\n")))))

(define (php-dump-label-name num baton)
  (display "lbl_")
  (display (proc-obj-c-name (get-dump-proc baton)))
  (display "_")
  (display num))

(define (php-dump-loc loc baton)
  (cond
    [(reg? loc) (display "$reg")(display (reg-num loc))]
    [(stk? loc) (display "$stack[$fp")
                (display-with-plus-or-minus
                  (- (stk-num loc) (get-dump-fp-offset baton)))
                (display "]")]
    [(obj? loc) (php-dump-scheme-object (obj-val loc))]
    [(glo? loc) (display "'glo_")(display (glo-name loc))(display "'")]
    [(lbl? loc) (display "'")
                (php-dump-label-name (lbl-num loc) baton)
                (display "'")]
    [else       (display "loc#")(display loc)])
  (display " "))

(define (php-dump-scheme-object obj)
  (if (proc-obj? obj)
    (begin (scan-obj obj)
           (display "'glo_")(display (proc-obj-c-name obj))(display "'"))
    (write obj)))

(define (php-dump-instr-jump instr baton)
  (display "$pc = ")
  (php-dump-loc (jump-opnd instr) baton)
  (display ";\n"))

(define (php-dump-instr-ifjump instr baton)
  (display "$f=")(php-dump-scheme-object (ifjump-test instr))
  (display ";\nif($f(")
  (let loop (
             [comma ""]
             [opnds (ifjump-opnds instr)])
    (or (null? opnds)
        (begin
          (display comma)
          (php-dump-loc (car opnds) baton)
          (loop ", " (cdr opnds)))))
  (display ")) {")
  (let ((print-jump-loc (lambda (loc)
                (and loc (begin
                    (display " $pc=")
                    (php-dump-label-name loc baton)
                    (display ";"))))))
    (print-jump-loc (ifjump-true instr))
    (let ((false-loc (ifjump-false instr)))
      (if false-loc (begin
          (display " } else {")
          (print-jump-loc false-loc)))))
  (display " }\n")
)

;;;============================================================================
