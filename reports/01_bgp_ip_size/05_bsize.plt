set terminal pdf

#set xdata time
#set timefmt "%Y-%m-%d"
#set format x ""
set logscale y
#set key left
set xlabel 'Countries'
set ylabel 'Number of addresses, power of 2'
set title  'Distribution of BGP announced IP space'

set yrange [256:1e10]

unset xtics
plot \
	'< egrep "North America" bgp_stat-regions.txt'	using 1:7 title 'North America'			ps 2 lw 3 pt 2, \
	'< egrep "South America" bgp_stat-regions.txt'	using 1:7 title 'South America'			ps 2 lw 3 pt 2, \
	'< egrep "Europe" bgp_stat-regions.txt'			using 1:7 title 'Europe'				ps 2 lw 3 pt 2, \
	'< egrep "Asia" bgp_stat-regions.txt'			using 1:7 title 'Asia-Pacific Region'	ps 2 lw 3 pt 2, \
	'< egrep "Africa" bgp_stat-regions.txt'			using 1:7 title 'Africa'				ps 2 lw 3 pt 2, \
	'< egrep "Other" bgp_stat-regions.txt'			using 1:7 title 'Other'					ps 2 lw 3 pt 2
