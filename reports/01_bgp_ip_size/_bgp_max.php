<?php

include( "../dates.php" );
include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

print "#Date\t#announcements\t#ipSpace\tratio\n";
$sql="
		select on_date,max(count) as count, max(size) as size, max(size)/max(count) as ratio 
		FROM
(select on_date,name,sum(count) as count,sum(size) as size,sum(size)/sum(count) as ratio
from bgp_counts c join bgp_sources s on c.source=s.id
group by on_date,source,name
order by on_date) as tbl
group by on_date
ORDER BY on_date
";
	$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
		print "$row[on_date]\t$row[count]\t$row[size]\t$row[ratio]\n";
	}



