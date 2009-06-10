<?php

include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

$date=$argv[1];

$sql="select (CASE WHEN to_char(rir_date,'YYYY') IS NULL THEN 'unknown' ELSE to_char(rir_date,'YYYY') END),count(*),sum(size) 
			from ipv4 
			where on_date='$date' 
			group by to_char(rir_date,'YYYY')
			order by to_char(rir_date,'YYYY') NULLS FIRST";

$res=$DB->Execute( $sql );
foreach( $res as $row )
{
	print "$row[0]\t$row[1]\t$row[2]\n"; 
}

