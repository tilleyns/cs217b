set terminal pdf

#set style fill   solid 4.00 noborder
#set style data histograms

#set key under nobox
set grid y
set auto y
#set logscale y

#set yrange [0:40000]

set xrange [0:20]

#set title 'BGP announced prefix distribution'
set xlabel 'Countries'
set ylabel 'Number of IP addresses'

unset xtics

plot 'bgp_stat-size-distr-2003.txt' using 3 every 1 title '2003' with linespoints lw 3, \
	 'bgp_stat-size-distr-2009.txt' using 3 every 1 title '2009' with linespoints lw 3


#plot '< grep 2003-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2003', \
#	 '< grep 2004-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2004', \
#	 '< grep 2005-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2005', \
#	 '< grep 2006-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2006', \
#	 '< grep 2007-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2007', \
#	 '< grep 2008-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2008', \
#	 '< grep 2009-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2009', \
#	 '< grep 2009-04-23 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title 'May 2009'

