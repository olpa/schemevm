(define (fact x)
  (if (zero? x) 1
      (* (fact (- x 1)) x)))
(display (fact 5)) (newline)
