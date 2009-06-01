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
				"drop table if exists bgp_temp;
				create table bgp_temp as select covered,covering from bgp where on_date='$date' and source='$source';

select covered,covering,total,covered1
from 
(select count(*) as covered from bgp_temp where covered is NOT NULL) m,
(select count(*) as covering from bgp_temp where covering Is not null) f,
(select count(*) as total from bgp_temp where covered is null and covering is null) t,
(select count(*) as covered1 from bgp_temp where covered=1) c1

";
	$row=$DB->GetRow( $sql );
	print "$date\t$row[covered]\t$row[covering]\t$row[total]\t$row[covered1]\n";
}

