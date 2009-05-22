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
select 32-log(2,size)::integer as prefix,count(*) as count,sum(size) as size,sum(size)/count(*) as ratio
from ipv4 
where on_date='$date' 
group by size 
order by size desc
";
	$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
		print "$date\t$row[prefix]\t$row[count]\t$row[size]\t$row[ratio]\n";
	}
	print "\n";
#	die;
}


