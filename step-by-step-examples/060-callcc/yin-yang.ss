;(declare (standard-bindings) (fixnum) (not safe))
; example is taken from http://en.wikipedia.org/wiki/Call-with-current-continuation

(let* ((yin
         ((lambda (cc) (display #\@) cc)
          (call-with-current-continuation (lambda (c) c))))
       (yang
         ((lambda (cc) (display #\*) cc)
          (call-with-current-continuation (lambda (c) c)))) )
    (yin yang))
