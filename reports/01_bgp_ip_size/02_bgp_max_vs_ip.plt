set terminal pdf

set xdata time
set timefmt "%Y-%m-%d"
set format x "%Y/%b"

set key left
set xlabel 'Date'
set ylabel 'Number of prefixes'
set grid y

set title 'Number of BGP entries versus number of allocated blocks'

plot \
	'bgp_stat.txt'	using 1:3 with lines title 'BGP Announcements (Amsterdam)' lt 2 lw 3, \
	'ip_stat.txt' using 1:2 with lines title 'IP Assignments and Allocations' lt 3 lw 3

