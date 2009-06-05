set terminal pdf

set xdata time
set timefmt "%Y-%m-%d"
set format x "%Y/%b"

set key left
set xlabel 'Date'
set ylabel 'Number of prefixes, power of 2'
set title 'Announced IP space versus allocated IP space'

set grid y

set style fill pattern 1

LABEL = "             "
set obj 10 rect at '2003-07-01',30.5 size char strlen(LABEL), char 1.5 
set obj 10 fillstyle solid 1 noborder fillcolor rgb "#FFFFFF" front

set obj 20 rect at '2008-11-01',31.12 size char strlen(LABEL), char 1.5 
set obj 20 fillstyle solid 1 noborder fillcolor rgb "#FFFFFF" front

set label "36% unused" at '2003-07-01',30.5 front center
set label "27% unused" at '2008-11-01',31.12 front center

set xrange ['2003-01-01':'2009-04-23']

plot \
	'ip_stat.txt' using 1:(log($3)/log(2)) with lines title 'Allocated IP space' lw 3,\
	'bgp_stat.txt'	using 1:(log($4)/log(2)) with lines title 'BGP Announced IP space' lw 3,\
	'< paste ip_stat.txt bgp_stat.txt' using 1:(log($3)/log(2)):(log($8)/log(2)) with filledcu title 'Globally unused IP space'


