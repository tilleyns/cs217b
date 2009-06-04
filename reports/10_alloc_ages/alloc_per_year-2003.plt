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

#set xrange [0:300]

set xtics nomirror rotate by -45 scale 0

plot 'stat-03.txt' using 2:xtic(1) notitle with impulses lw 20
#boxes 000099
