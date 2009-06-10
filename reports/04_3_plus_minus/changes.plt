#set terminal postscript
set terminal pdf
#set grid 
#set terminal windows
#set bmargin 
#set lmargin 
#set rmargin 
#set tmargin 

set xdata time
set timefmt "%Y-%m-%d"
set format x "%Y/%b"

set key right

set title 'Changes in IP allocations'
set xlabel 'Date'
set ylabel 'Cumulative # of prefixes'

set grid y

set key left

set xrange ['2003-01-01':'2009-04-23']

set arrow from '2003-10-01',10000 to '2004-01-01',4700
set arrow from '2003-10-10',10000 to '2004-04-01',5300

set label "IP space reorganization" at '2003-10-01',11000 center 


set arrow from '2004-10-01',17000 to '2005-02-01',6000
set arrow from '2004-10-10',17000 to '2005-05-15',12500

set label "Temporary prefix disappearance" at '2004-10-01',18000 center


plot  \
"<awk '{n=n+$2; s=s+$3; e=e+$4; d=d+$5; print $1,n,s,e,d}' stat.txt"	\
	using 1:2 title 'New allocations' with lines lt 1 lw 3, \
''	using 1:3 title 'New allocation due to prefix splitting' with lines lt 2 lw 3, \
''	using 1:4 title 'Prefix extensions' with lines lt 3 lw 3, \
''  using 1:5 title 'Deallocation' with lines lt 4 lw 3
#"<awk '{n=n+$2; s=s+$3; e=e+$4; d=d+$5; print $1,n,s,e,d}' stat.txt" \

