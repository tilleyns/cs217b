<?php

include( "../dates.php" );
include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

print "#Date\tPrefix\t#allocations\t#ipSpace\tratio\n";
foreach( $DATES as $date )
{
		$sql=
"
select  prefix,
	(CASE WHEN b.size IS NULL THEN 0 ELSE count(*) END) as count,
	(CASE WHEN b.size IS NULL THEN 0 ELSE sum(size)END) as size,
	(CASE WHEN b.size IS NULL THEN 0 ELSE sum(size)/count(*) END) as ratio
	    from (select prefixes as prefix,2^(32-prefixes) as prefixes from prefixes()) as pr
	    left join bgp b on (prefixes=size and on_date='$date' and source='3')
	    left join bgp_sources s ON b.source=s.id
	group by prefix,b.size
	order by prefix
";
#"
#select	name as bgpname, source,
#		32-log(2,size)::integer as prefix,
#		count(*) as count,
#		sum(size) as size,
#		sum(size)/count(*) as ratio
#	from prefixes() as pr
#	left join bgp b on pr.prefixes=b.prefix
#	left join bgp_sources s ON b.source=s.id
#	where on_date='$date' or on_date is null
#	group by source,name,size 
#	order by source,prefix 
#";
	$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
		print "$date\t\"\"\t\"\"\t$row[prefix]\t$row[count]\t$row[size]\t$row[ratio]\n";
	}
	print "\n";
#	die;
}


