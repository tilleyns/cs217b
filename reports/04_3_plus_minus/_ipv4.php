<?php

include( "../dates.php" );
include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

print "#Date\tNew Allocations\tNew from splitting\tPrefix extension\tDeallocation\n";
foreach( $DATES as $date )
{
	$sql=
"
select * 
from
(select count(*) as new_alloc from ipv4 where on_date='$date' and \"new\"='t' ) n,
		(select sum(splitting)-1 as new_split from ipv4 where on_date='$date' and splitting>0) s,
		(select count(*) as extended from ipv4 where on_date='$date' and \"extension\">1 ) e,
		(select count(*) as dealloc from ipv4 where on_date='$date' and deallocation='t' ) d
";
	$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
			if( !isset($row['new_split']) ) $row['new_split']=0;
		print "$date\t$row[new_alloc]\t$row[new_split]\t$row[extended]\t$row[dealloc]\n";
	}
#	die;
}


