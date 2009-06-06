set terminal pdf

set style fill solid 1.00 
set title 'How long prefixes have been seen in BGP announcements'
set xlabel 'Ages, weeks'
set ylabel 'Number of Prefixes'
set xtics

set grid y
#set style data histograms
#set style histogram clustered gap 1
#set tics scale 20

set xrange [0:351]

set xtics ("0" 0, "50" 50, "100" 100, "150" 150, "200" 200, "250" 250, "300" 300, ">350" 350)

plot 'ages.csv' using ($1*4):2 notitle with impulses lw 10
#boxes 000099
