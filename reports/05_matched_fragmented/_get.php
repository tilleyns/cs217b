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
				"drop table if exists bgp_temp2;
				create table bgp_temp2 as select matched,fragmented,aggregated from bgp where source='$source' and on_date='$date';
				
				select matched,fragmented,aggregated 
from 
(select count(*) as matched from bgp_temp2 where matched='t') m,
(select count(*) as fragmented from bgp_temp2 where fragmented='t') f,
(select count(*) as aggregated from bgp_temp2 where aggregated='t') a
";
	$row=$DB->GetRow( $sql );
	print "$date\t$row[matched]\t$row[fragmented]\t$row[aggregated]\n";
}

