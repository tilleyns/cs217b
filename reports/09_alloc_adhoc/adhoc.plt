set terminal pdf

set title 'Prefixes induced by unaligned IP allocation'
set xlabel 'Year of allocation'
set ylabel 'Number of prefixes'


#set ydata time
#set timefmt "%Y-%m-%d"
#set format y "%Y/%b"

#set border 3 front linetype -1 linewidth 1.000
#set boxwidth 1 absolute

set style fill   solid 4.00 noborder
#set grid nopolar
#set grid noxtics nomxtics ytics nomytics noztics nomztics \
# nox2tics nomx2tics noy2tics nomy2tics nocbtics nomcbtics
#set grid layerdefault   linetype 0 linewidth 1.000,  linetype 0 linewidth 1.000
#set key bmargin center horizontal Left reverse enhanced autotitles columnhead nobox
#set datafile missing '-'
set style data histograms


#set pm3d
#set style histogram clustered gap 8
#title offset 4,0.25
#set style fill solid noborder
#set boxwidth 0.95

set key under nobox
set grid y
set auto y
#set logscale y

set xtics nomirror rotate by -45 scale 0


plot 'stat.txt' using 2:xtic(1) notitle \
