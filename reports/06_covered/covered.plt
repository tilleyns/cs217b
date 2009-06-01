set terminal pdf

set title 'Covered / covering / mathching prefixes dynamics'
set xlabel 'Time'
set ylabel 'Number of prefixes'

#set border 3 front linetype -1 linewidth 1.000
#set boxwidth 1 absolute

#set border 3 front linetype -1 linewidth 1.000
#set boxwidth 0.75 absolute
#set style fill   solid 1.00 border -1

set xdata time
set timefmt "%Y-%m-%d"
set format x "%Y/%b"

#set style fill   solid 3.00 noborder
#set grid nopolar
#set grid noxtics nomxtics ytics nomytics noztics nomztics \
# nox2tics nomx2tics noy2tics nomy2tics nocbtics nomcbtics
#set grid layerdefault   linetype 0 linewidth 1.000,  linetype 0 linewidth 1.000
#set key bmargin center horizontal Left reverse enhanced autotitles columnhead nobox
#set datafile missing '-'
#set style data histograms
#set style histogram rowstacked title  offset character 0, 0, 0

#columnstacked gap 1


#set pm3d
#set style histogram clustered gap 1
#title offset 4,0.25
#set style fill solid noborder
#set boxwidth 0.95

set key left
#under nobox
set grid y
set auto y
#set logscale y

#set ytics border in scale 0,0 mirror norotate  offset character 0, 0, 0 autofreq 
#set ztics border in scale 0,0 nomirror norotate  offset character 0, 0, 0 autofreq 
#set cbtics border in scale 0,0 mirror norotate  offset character 0, 0, 0 autofreq 

#set xtics nomirror rotate by -45 scale 0


plot 'stat.txt' u 1:4 title 'Unique' with linespoints lw 3 pt 1,\
	 '' using 1:($2-$5) title '2+ Level Covered' with linespoints lw 3 pt 2, \
	 '' using 1:5 title '1-Level Covered' with linespoints lw 3 pt 2,\
	 '' u 1:3 title 'Covering' with linespoints lw 3 pt 4
	 



