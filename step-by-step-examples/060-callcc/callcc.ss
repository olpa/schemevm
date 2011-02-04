; Taken from CPSCM
;
; FIXME: this example does not work, because
; "dynamic-wind" is not implemented.

(let ()
  (define in #f)
  (define cnt 3)
  (call/cc
   (lambda (out)
     (dynamic-wind
         (lambda () (display "Before") (newline))
         (lambda ()
           (display "Thunk")
           (newline)
           (call/cc
            (lambda (cc) (set! in cc) (out #f)))
           (set! cnt (- cnt 1))
           (display "Finishing thunk") (newline))
       (lambda () (display "After") (newline)))))
  (if (> cnt 0) (in #f)))

; should display:
; Before
; Thunk
; After
; Before
; Finishing thunk
; After
; last 3 lines repeated 3 times
