(declare (standard-bindings) (fixnum) (not safe))
(define fib
  (lambda (n)
    (if (< n 3)
      1
      (+ (fib (- n 1)) (fib (- n 2))))))
(display (fib 15))(newline) ; should be 610
