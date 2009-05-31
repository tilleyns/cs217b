set terminal pdf

#set xdata time
#set timefmt "%Y-%m-%d"
#set format x ""
set logscale y
#set key left
set xlabel 'Countries'
set ylabel 'Number of prefixes'


unset xtics
plot \
	'< grep "North America" ip_stat-regions.txt'	using 1:5 title 'North America'			ps 2 lw 3 pt 2, \
	'< grep "South America" ip_stat-regions.txt'	using 1:5 title 'South America'			ps 2 lw 3 pt 2, \
	'< grep "Europe" ip_stat-regions.txt'			using 1:5 title 'Europe'				ps 2 lw 3 pt 2, \
	'< grep "Asia" ip_stat-regions.txt'				using 1:5 title 'Asia-Pacific Region'	ps 2 lw 3 pt 2, \
	'< grep "Africa" ip_stat-regions.txt'			using 1:5 title 'Africa'				ps 2 lw 3 pt 2, \
	'< grep "Other" ip_stat-regions.txt'			using 1:5 title 'Other'					ps 2 lw 3 pt 2
