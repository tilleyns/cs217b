DATES=2003-01-01 2004-01-01 2005-01-01 2006-01-01 2007-01-01 2008-01-01 2009-01-01 2009-04-23

PDF=01_bgp_ip_size.pdf 02_bgp_max_vs_ip.pdf 02_bgp_max_vs_ip_space.pdf 03_bgp_ip_space.pdf 04_bgp_ratio.pdf \
	$(patsubst %,05_ip_%.pdf,$(DATES))\
	$(patsubst %,05_isize_%.pdf,$(DATES))\
	$(patsubst %,05_bgp_%.pdf,$(DATES)) \
	$(patsubst %,05_bsize_%.pdf,$(DATES)) \
	prefix-distr.pdf size-distr.pdf

#\
#	$(patsubst %,bgp_%.js,$(DATES)) \
#	$(patsubst %,ip_%.js,$(DATES))


all: pdf

pdf: $(PDF)

05_ip_%.pdf: 05_ip.plt
	#php _ipv4-table.php $* > ip_stat-regions-$*.txt
	cp ip_stat-regions-$*.txt ip_stat-regions.txt
	gnuplot 05_ip.plt > 05_ip_$*.pdf

05_isize_%.pdf: 05_isize.plt
	#php _ipv4-table.php $* > ip_stat-regions-$*.txt
	cp ip_stat-regions-$*.txt ip_stat-regions.txt
	gnuplot 05_isize.plt > 05_isize_$*.pdf

05_bgp_%.pdf: 05_bgp.plt
	#php _bgp.php $* > bgp_stat-regions-$*.txt
	cp bgp_stat-regions-$*.txt bgp_stat-regions.txt
	gnuplot 05_bgp.plt > 05_bgp_$*.pdf

05_bsize_%.pdf: 05_bsize.plt
	#php _bgp.php $* > bgp_stat-regions-$*.txt
	cp bgp_stat-regions-$*.txt bgp_stat-regions.txt
	gnuplot 05_bsize.plt > 05_bsize_$*.pdf

bgp_%.js: _bgp.php 
	php _bgp.php $* js > bgp_$*.js

ip_%.js: _ipv4.php
	php _ipv4.php $* > ip_$*.js

%.pdf: %.plt
	gnuplot $< > $@

bgp:
	#php _bgp_max.php > bgp_max.txt
	php _bgp_sum.php > bgp_stat.txt
	for i in 2 3 4 5 6; do php _bgp_sum.php $$i > bgp_stat_$$i.txt; done

ip:
	php _ipv4.php 2003-01-01 ip2003 count > ip_count_2003.js
	php _ipv4.php 2004-01-01 ip2004 count > ip_count_2004.js
	php _ipv4.php 2005-01-01 ip2005 count > ip_count_2005.js
	php _ipv4.php 2006-01-01 ip2006 count > ip_count_2006.js
	php _ipv4.php 2007-01-01 ip2007 count > ip_count_2007.js
	php _ipv4.php 2008-01-01 ip2008 count > ip_count_2008.js
	php _ipv4.php 2009-04-23 ip2009 count > ip_count_2009.js
	\
	php _ipv4.php 2003-01-01 ipSpace2003 size > ip_size_2003.js
	php _ipv4.php 2004-01-01 ipSpace2004 size > ip_size_2004.js
	php _ipv4.php 2005-01-01 ipSpace2005 size > ip_size_2005.js
	php _ipv4.php 2006-01-01 ipSpace2006 size > ip_size_2006.js
	php _ipv4.php 2007-01-01 ipSpace2007 size > ip_size_2007.js
	php _ipv4.php 2008-01-01 ipSpace2008 size > ip_size_2008.js
	php _ipv4.php 2009-04-23 ipSpace2009 size > ip_size_2009.js

