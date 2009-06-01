set terminal pdf

set style fill solid 1.00 
set xlabel 'Ages, weeks'
set ylabel 'Number of Prefixes'
set xtics

set grid y
#set style data histograms
#set style histogram clustered gap 1
#set tics scale 20

plot 'ages.csv' using ($1*4):2 notitle with impulses lw 10
#boxes 000099
