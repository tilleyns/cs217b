set terminal pdf

set xdata time
set timefmt "%Y-%m-%d"
set format x "%Y/%b"

set key left
set xlabel 'Date'
set ylabel 'Number of prefixes'

set grid y

set xrange ['2003-01-01':'2009-04-23']

set arrow 1 from '2007-10-01',70000 to '2006-10-01',120000
set label "Temporary failures \nof BGP monitor" at '2007-11-01',70000

plot \
	'bgp_stat_2.txt'	using 1:3 with lines title 'RouteView Oregon' lw 2, \
	'bgp_stat_3.txt'	using 1:3 with lines title 'RIPE Amsterdam' lw 4  , \
	'bgp_stat_4.txt'    using 1:3 with lines title 'RIPE Tokio' lw 2, \
    'bgp_stat_5.txt'    using 1:3 with lines title 'RIPE London' lw 2, \
	'bgp_stat_6.txt'    using 1:3 with lines title 'RIPE Moscow' lw 2 

