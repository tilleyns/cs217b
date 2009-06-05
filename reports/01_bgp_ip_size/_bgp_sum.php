<?php

include( "../dates.php" );
include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

$source=isset($argv[1])?$argv[1]:"3";

print "#Date\t#announcements\t#ipSpace\tratio\n";
$sql="
select on_date,name,sum(count) as count,sum(size) as size,sum(size)/sum(count) as ratio
from bgp_counts c join bgp_sources s on c.source=s.id
group by on_date,source,name
order by on_date
";
$sql="select s.on_date,c.count,s.size,s.size/c.count as ratio
			from bgp_counts c
			join bgp_sizes s on s.on_date=c.on_date and s.source=c.source
			where s.source='$source'
			order by on_date";

	$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
		print "$row[on_date]\t$source\t$row[count]\t$row[size]\t$row[ratio]\n";
	}



