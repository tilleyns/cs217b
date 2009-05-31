set terminal pdf

set xdata time
set timefmt "%Y-%m-%d"
set format x "%Y/%b"

set key left
set xlabel 'Date'
set ylabel 'Number of prefixes'

plot \
	'< grep amsterdam bgp_stat.txt'	using 1:3 with lines title 'BGP Annoncements' lw 2, \
	'ip_stat.txt' using 1:2 with lines title 'IP Assignemnts and Allocations' lw 2

