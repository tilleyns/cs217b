<?php

include( "../dates.php" );
include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );
$source=$argv[1];

#print "#Date\tPrefix\t#allocations\t#ipSpace\tratio\n";
foreach( $DATES as $date )
{
		$sql=
"select matched,fragmented,aggregated 
from 
(select count(*) as matched from bgp where matched='t' and source='$source' and on_date='$date') m,
(select count(*) as fragmented from bgp where fragmented='t' and source='$source' and on_date='$date') f,
(select count(*) as aggregated from bgp where aggregated='t' and source='$source' and on_date='$date') a
";
	$row=$DB->GetRow( $sql );
	print "$date\t$row[matched]\t$row[fragmented]\t$row[aggregated]\n";
}

