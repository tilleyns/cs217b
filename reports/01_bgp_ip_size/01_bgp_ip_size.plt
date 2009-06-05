set terminal pdf

set xdata time
set timefmt "%Y-%m-%d"
set format x "%Y/%b"

set key left
set xlabel 'Date'
set ylabel 'Number of prefixes'

plot \
	'bgp_stat_2.txt'	using 1:3 with lines title 'RouteView Oregon' lw 2, \
	'bgp_stat_3.txt'	using 1:3 with lines title 'RIPE Amsterdam' lw 2, \
	'bgp_stat_4.txt'    using 1:3 with lines title 'RIPE Tokio' lw 2, \
    'bgp_stat_5.txt'    using 1:3 with lines title 'RIPE London' lw 2, \
	'bgp_stat_6.txt'    using 1:3 with lines title 'RIPE Moscow' lw 2 

