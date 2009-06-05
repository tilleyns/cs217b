set terminal pdf

set xdata time
set timefmt "%Y-%m-%d"
set format x "%Y/%b"

set key left
set xlabel 'Date'
set ylabel 'Number of prefixes'
set grid y

set title 'Number of BGP entries versus number of allocated blocks'

set xrange ['2003-01-01':'2009-04-23']

set label '2.24x allocated prefixes' at '2003-02-20',130000 rotate by 90 front
set label '3.06x allocated prefixes' at '2009-03-01',180000 rotate by 90 front

plot \
	'bgp_stat.txt'	using 1:3 with lines title 'BGP Announcements (Amsterdam)' lt 2 lw 3, \
	'ip_stat.txt' using 1:2 with lines title 'IP Assignments and Allocations' lt 3 lw 3

