set terminal pdf

set xdata time
set timefmt "%Y-%m-%d"
set format x "%Y/%b"

set key left
set xlabel 'Date'
set ylabel 'Number of prefixes'

plot \
	'< grep ripe-amsterdam bgp_stat.txt'	using 1:4 with lines title 'RouteView Amsterdam' lw 2, \
	'< grep oregon bgp_stat.txt'			using 1:4 with lines title 'RIPE Oregon' lw 2, \
	'< grep japan  bgp_stat.txt'            using 1:4 with lines title 'RIPE Tokio' lw 2, \
    '< grep london bgp_stat.txt'            using 1:4 with lines title 'RIPE London' lw 2, \
	'< grep moscow  bgp_stat.txt'            using 1:4 with lines title 'RIPE Moscow' lw 2 

