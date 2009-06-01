set terminal pdf
#set terminal windows
#set xdata time
#set timefmt "%Y-%m-%d"
#set format x ""
set logscale y
#set key left

set title 'Geographic distribution of IP allocation dynamics (YEAR)'
set xlabel 'Countries'
set ylabel 'Number of new prefixes'


unset xtics
plot \
	'< grep "reg-10" plus_minus_stat.txt'	using 1:8 title 'North America'			ps 2 lw 3 pt 2, \
	'< grep "reg-15" plus_minus_stat.txt'	using 1:8 title 'South America'			ps 2 lw 3 pt 2, \
	'< grep "reg-20" plus_minus_stat.txt'			using 1:8 title 'Europe'				ps 2 lw 3 pt 2, \
	'< grep "reg-30" plus_minus_stat.txt'				using 1:8 title 'Asia-Pacific Region'	ps 2 lw 3 pt 2, \
	'< grep "reg-40" plus_minus_stat.txt'			using 1:8 title 'Africa'				ps 2 lw 3 pt 2, \
	'< grep "reg-50" plus_minus_stat.txt'			using 1:8 title 'Other'					ps 2 lw 3 pt 2
#\
#	'< grep "reg-10" plus_minus_stat.txt'	using 1:7 notitle				ps 2 lw 3 pt 4 lt 1, \
#	'< grep "reg-15" plus_minus_stat.txt'	using 1:7 notitle				ps 2 lw 3 pt 4 lt 2, \
#	'< grep "reg-20" plus_minus_stat.txt'			using 1:7 notitle 		ps 2 lw 3 pt 4 lt 3, \
#	'< grep "reg-30" plus_minus_stat.txt'				using 1:7 notitle 	ps 2 lw 3 pt 4 lt 4, \
#	'< grep "reg-40" plus_minus_stat.txt'			using 1:7 notitle		ps 2 lw 3 pt 4 lt 5, \
#	'< grep "reg-50" plus_minus_stat.txt'			using 1:7 notitle  		ps 2 lw 3 pt 4 lt 6
