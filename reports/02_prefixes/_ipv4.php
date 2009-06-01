<?php

include( "../dates.php" );
include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

print "#Date\tPrefix\t#allocations\t#ipSpace\tratio\n";
foreach( $DATES as $date )
{
	$sql=
"select 
	prefix,
	(CASE WHEN i.size IS NULL THEN 0 ELSE count(*) END) as count,
	(CASE WHEN i.size IS NULL THEN 0 ELSE sum(i.size) END) as size,
	(CASE WHEN i.size IS NULL THEN 0 ELSE sum(i.size)/count(*) END) as ratio
	from (select prefixes as prefix, 2^(32-prefixes) as size from prefixes() ) p
	left join ipv4 i on p.size=i.size and on_date='$date' and is_adhoc='f'
	group by prefix,i.size
	order by prefix";
#"
#select 32-log(2,size)::integer as prefix,count(*) as count,sum(size) as size,sum(size)/count(*) as ratio
#from ipv4 
#where on_date='$date' 
#group by size 
#order by size desc
#";
	$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
		print "$date\t$row[prefix]\t$row[count]\t$row[size]\t$row[ratio]\n";
	}
	print "\n";
#	die;
}


