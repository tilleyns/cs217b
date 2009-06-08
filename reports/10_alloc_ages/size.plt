set terminal pdf

set style fill solid 1.00 
set title 'Yearly distribution of prefix allocations'
set xlabel 'Year'
set ylabel 'Number of Prefixes'
set xtics

set grid y
#set style data histograms
#set style histogram clustered gap 1
#set tics scale 20

set xrange [0:29]

set xtics ("Unknown" 0,"1985" 3, "1990" 8, "1995" 13,"2000" 18, "2005" 23) 
#nomirror rotate by -45 scale 0

plot 'stat.txt' using 3 notitle with impulses lw 20
#boxes 000099
