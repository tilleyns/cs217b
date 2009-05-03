<?php

include_once( "adodb/adodb.inc.php" );
$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );
if( !$DB ) 
{
	print "Error";
	exit;
}

//system( "wget ftp://ftp.arin.net/pub/stats/arin/delegated-arin-latest > /tmp/delegated" );
$file=fopen( "/tmp/delegated", 'r' );
if( !$file ) exit;
while( !feof($file) )
{
	$data=fgetcsv( $file, 5000, "|" );
	
	//ripencc|NL|ipv4|24.132.0.0|32768|19971013|allocated ^M
        if( $data[2]!="ipv4" && $data[3]!="*" ) continue;

	$sql1="INSERT INTO ipv4 (on_date,RIR,country,IP,is_adhoc,RIR_date,type) VALUES(";
	
	$RIR_date=substr($data[5],0,4)."-".substr($data[5],4,2)."-".substr($data[5],6,2);
	
	
}

?>

