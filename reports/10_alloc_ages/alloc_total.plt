set terminal pdf

set style fill solid 1.00 
set title 'Yearly distribution of prefix allocations'
set xlabel 'Year'
set ylabel 'Number of Prefixes'
set xtics

set key under nobox 

set grid y
set style data histograms
set style histogram clustered gap 1
#set tics scale 20

#set xrange [0:29]

set xtics ("Unknown" 0,"1985" 3, "1990" 8, "1995" 13,"2000" 18, "2005" 23, '2009' 27) 
#nomirror rotate by -45 scale 0

#'stat-2004-01-01.txt' using 2 title "2004", \
#	 'stat-2006-01-01.txt' using 2 title "2007", \
#	 'stat-2009-01-01.txt' using 2 title "2009", \
#	 'stat-2006-01-01.txt' using 2 title "2006" lt 3, \

plot 'stat-2003-01-01.txt' using 2 title "2003" lt 1, \
 	 'stat-2005-01-01.txt' using 2 title "2005" lt 3, \
	 'stat-2007-01-01.txt' using 2 title "2007" lt 5, \
	 'stat-2009-04-23.txt' using 2 title "2009" lt 7

#boxes 000099
#plot 'stat-2003-01-01.txt' using 2 notitle with impulses lw 20, \
#	 'stat-2006-01-01.txt' using 2 notitle with impulses lw 20, \
#	 'stat-2009-04-23.txt' using 2 notitle with impulses lw 20
#boxes 000099
