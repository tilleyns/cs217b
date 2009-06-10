set terminal pdf

#set style fill   solid 4.00 noborder
#set style data histograms

#set key under nobox
set grid y
set auto y
set logscale y

#set xrange [0:20]

#set yrange [0:40000]

#set title 'BGP announced prefix distribution'
set xlabel 'Countries'
set ylabel 'Number of prefixes'

unset xtics

plot 'temp.txt' every 1  using 4 title '2003' with linespoints lw 3
#, \
#	 'bgp_stat-count-distr-2009.txt' every 2 using 2 title '2009' with linespoints lw 3


#plot '< grep 2003-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2003', \
#	 '< grep 2004-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2004', \
#	 '< grep 2005-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2005', \
#	 '< grep 2006-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2006', \
#	 '< grep 2007-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2007', \
#	 '< grep 2008-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2008', \
#	 '< grep 2009-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title '2009', \
#	 '< grep 2009-04-23 bgp-amsterdam.txt' using 5:xtic(4) every ::12 title 'May 2009'

