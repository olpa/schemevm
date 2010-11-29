(declare (standard-bindings) (fixnum) (not safe))
(define mkadder
  (lambda (a)
    (lambda (b)
      (lambda (c)
        (lambda (d)
          (+ a b c d))))))
(define xadder (((mkadder 1) 2) 3))
(display (xadder 4))(newline)
