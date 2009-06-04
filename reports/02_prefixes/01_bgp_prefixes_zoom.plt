set terminal pdf

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
set title 'BGP announced prefix distribution'
set xlabel 'Prefix length'
set ylabel 'Number of prefixes'

set yrange [0:160000]

plot '< grep 2003-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12::23 title '2003', \
	 '< grep 2004-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12::23 title '2004', \
	 '< grep 2005-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12::23 title '2005', \
	 '< grep 2006-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12::23 title '2006', \
	 '< grep 2007-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12::23 title '2007', \
	 '< grep 2008-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12::23 title '2008', \
	 '< grep 2009-01-01 bgp-amsterdam.txt' using 5:xtic(4) every ::12::23 title '2009', \
	 '< grep 2009-04-23 bgp-amsterdam.txt' using 5:xtic(4) every ::12::23 title 'May 2009'

