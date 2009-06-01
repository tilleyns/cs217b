set terminal pdf
#set terminal windows
#set xdata time
#set timefmt "%Y-%m-%d"
#set format x ""
set logscale y
#set key left
set xlabel 'Countries'
set ylabel 'Number of new prefixes'
set title 'Geographic distribution of IP allocation dynamics (2007)'

unset xtics
plot \
	'< grep "North America" ipv4datapercountrywithregions2007.csv'	using 1:($5-$6) title 'North America'			ps 2 lw 3 pt 2, \
	'< grep "South America" ipv4datapercountrywithregions2007.csv'	using 1:($5-$6) title 'South America'			ps 2 lw 3 pt 2, \
	'< grep "Europe" ipv4datapercountrywithregions2007.csv'			using 1:($5-$6) title 'Europe'				ps 2 lw 3 pt 2, \
	'< grep "Asia" ipv4datapercountrywithregions2007.csv'				using 1:($5-$6) title 'Asia-Pacific Region'	ps 2 lw 3 pt 2, \
	'< grep "Africa" ipv4datapercountrywithregions2007.csv'			using 1:($5-$6) title 'Africa'				ps 2 lw 3 pt 2, \
	'< grep "Other" ipv4datapercountrywithregions2007.csv'			using 1:($5-$6) title 'Other'					ps 2 lw 3 pt 2
