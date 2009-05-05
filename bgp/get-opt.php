<?php

#include_once( "adodb/adodb-exceptions.inc.php" );
#include_once( "adodb/adodb.inc.php" );
#$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );
#if( !$DB ) 
#{
#	print "Error\n";
#	exit;
#}

if( $argc<5 )
{
	print "Usage:\n";
	print "		php get-opt.php <URL> <NAME> <FROM_DATE> <TO_DATE> <SOURCE:rir|ripe>\n";
	exit( 1 );
}

$url=$argv[1];
$name=$argv[2];

$date=new DateTime( $argv[3] );
$last=new DateTime( $argv[4] );

$source=$argv[5];

while( $date<$last )
{
	$file=get_file( $date );

	$out="$name-".$date->format("Y-m-d");

	print ">> ".date( "h:i:s a" )."\n";
	parse_bgpdump_to_txt( $file,$out );
	print "<< ".date( "h:i:s a" )."\n";
	
	unlink( "$file" );
	
	$date->modify( "1 week" );
}

$old_yearmonth=null;
function get_file( $date )
{
	global $url, $old_format, $old_yearmonth, $source;

	if( $old_yearmonth!=$date->format("Y.m") )
	{
		$old_yearmonth=$date->format("Y.m");
		if( $source=="ripe" )
			system( "wget $url/$old_yearmonth/ -O $old_yearmonth 2>/dev/null" );
		else
			system( "wget $url/$old_yearmonth/RIBS/ -O $old_yearmonth 2>/dev/null" );

//		system( "mv index.html $old_yearmonth" );
	}

	if( $source=="ripe" )
	{
		$file=system( 'cat '.$old_yearmonth.' | sed -e "s/^.*\(bview.*gz\).*$/\1/g" | grep '.$date->format("Ymd")." | grep bview | head -1" );
		system( "wget $url/$old_yearmonth/$file 2>/dev/null" );
	}
	else
	{
		$file=system( 'cat '.$old_yearmonth.' | sed -e "s/^.*\(rib.*bz2\).*$/\1/g" | grep '.$date->format("Ymd")." | head -1" );
		system( "wget $url/$old_yearmonth/RIBS/$file 2>/dev/null" );
	}
	
	return $file;
}

function parse_bgpdump_to_txt( $file, $outfile )
{
	system( "../parseBGP $file | bzip2 -9c > $outfile.bz2" ); 	
}

