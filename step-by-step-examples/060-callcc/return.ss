(declare (standard-bindings) (fixnum) (not safe))

; example is taken from http://en.wikipedia.org/wiki/Call-with-current-continuation
(define (f return)
  (return 2)
  3)
 
(display (f (lambda (x) x)))(newline) ; displays 3
 
(display (call-with-current-continuation f))(newline) ; displays 2
