; Just curious, if unicode is supported.
;
; сделать-писалку == make-writer
; пиши-привет     == write-hello

(define (сделать-писалку s)
  (lambda () (display s)))
(define пиши-привет (сделать-писалку "Привет!\n"))
(пиши-привет)
