DATES=2003-01-01 2004-01-01 2005-01-01 2006-01-01 2007-01-01 2008-01-01 
#2009-01-01 2009-04-23

PDF=$(patsubst %,plus_minus_%.pdf,$(DATES))\
	$(patsubst %,plus_minus_%.js,$(DATES))

all: pdf

pdf: $(PDF)

plus_minus_%.pdf: plus_minus_scatter_t.plt _ipv4-table.php
	#php _ipv4-table.php $* table > plus_minus_stat_$*.txt
	cp plus_minus_stat_$*.txt plus_minus_stat.txt
	php plt-prepare.php $*
	gnuplot plus_minus_scatter.plt > plus_minus_$*.pdf

plus_minus_%.js: _ipv4-table.php
	php _ipv4-table.php $* js > plus_minus_$*.js

%.pdf: %.plt
	gnuplot $< > $@

