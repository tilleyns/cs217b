set terminal pdf

set xdata time
set timefmt "%Y-%m-%d"
set format x "%Y/%b"

set key left
set xlabel 'Date'
set ylabel 'Number of prefixes, power of 2'
set title 'Announced IP space versus allocated IP space'

set grid y

plot \
	'ip_stat.txt' using 1:(log($3)/log(2)) with lines title 'Allocated IP space' lw 3,\
	'< grep amsterdam bgp_stat.txt'	using 1:(log($4)/log(2)) with lines title 'BGP Announced IP space' lw 3


