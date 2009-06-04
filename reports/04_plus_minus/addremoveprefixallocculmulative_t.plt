#set terminal postscript
set terminal pdf
#set grid 
#set terminal windows
#set bmargin 
#set lmargin 
#set rmargin 
#set tmargin 
set timefmt "%Y-%m-%d"
set format x "%Y/%b"
set xdata time
set key right

set title 'CDF of IP allocation changes'
set xlabel 'Date'
set ylabel 'Prefixes'

set grid y

set key left
#plot 'datafile.dat' using 5:11 with lines
plot  \
'ipv4data.csv' using 1:($3-$5) title 'Total' with lines lt 3 lw 3

