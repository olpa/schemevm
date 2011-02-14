; Just curious, if unicode is supported.
;
; сделать-писателя == make-writer
; что-писать       == what-to-write
; пиши-привет      == write-hello

(define (сделать-писателя что-писать)
  (lambda () (display что-писать)))
(define пиши-привет (сделать-писателя "Привет!\n"))
(пиши-привет)
