<?php

include( "../dates.php" );
include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

print "#Date\t#allocations\t#ipSpace\tratio\n";
$sql="
select on_date,sum(count) as count,sum(size) as size,sum(size)/sum(count) as ratio
from ipv4_counts
group by on_date
order by on_date
";
	$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
		print "$row[on_date]\t$row[count]\t$row[size]\t$row[ratio]\n";
	}



