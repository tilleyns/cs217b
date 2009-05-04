<?php

include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );
$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );
if( !$DB ) 
{
	print "Error\n";
	exit;
}

//system( "wget ftp://ftp.arin.net/pub/stats/arin/delegated-arin-latest" );
if( $argc<6 )
{
	print "Usage:\n";
	print "		php get-opt.php <URL> <RIR> <FROM_DATE> <TO_DATE> <ZIP> <OLD-FORMAT>\n";
	exit( 1 );
}

$url=$argv[1];
$RIR=$argv[2];

$date=new DateTime( $argv[3] );
$last=new DateTime( $argv[4] );

$bzipped=$argv[5];
$old_format=$argv[6];

while( $date<$last )
{
	$file=get_file( $date );
	
	print ">> ".date( "h:i:s a" )."\n";
	parse_delegated( $date->format("Y-m-d"),$file,!$old_format );
	print "<< ".date( "h:i:s a" )."\n";
	
	unlink( "$file" );
	
	$date->modify( "1 week" );
}

function get_file( $date )
{
	global $bzipped, $url, $RIR, $old_format;

	if( $old_format=="apnic" )	
		$file="$RIR-".$date->format( "Y-m-d" );
	elseif( isset($old_format) )
		$file="$RIR.".$date->format( "Ymd" );
	else
		$file="delegated-$RIR-".$date->format( "Ymd" );
	
	print $file."\n";
	
	if( $bzipped=="" || $bzipped=="none" )
	{
		system( "wget $url/$file 2>/dev/null" );
	}
	else if( $bzipped=="gunzip" )
	{
		system( "wget $url/$file.gz 2>/dev/null" );
		system( "$bzipped $file.gz" );
	}
	else
	{
		system( "wget $url/$file.bz2 2>/dev/null" );
		system( "$bzipped $file.bz2" );
	}

	if( !file_exists($file) )
	{
		$newdate=new DateTime( $date->format("Y-m-d") );
		$newdate->modify( "1 day" );
		return get_file( $newdate );
	}
	
	return $file;
}


function parse_delegated( $on_date, $file, $new_format=true )
{
	global $DB;
	$file=fopen( $file, 'r' );
	if( !$file ) exit;
	while( !feof($file) )
	{
		$data=fgetcsv( $file, 5000, "|" );
		
		//ripencc|NL|ipv4|24.132.0.0|32768|19971013|allocated ^M
		if( $data[2]!="ipv4" || $data[1]=='*' ) continue;
	
		$block_size=$data[4];
		$rir    =$data[0];
		$country=$data[1];
		$ip_base=$data[3];
		
		if( $new_format )
		{
			$year=substr($data[5],0,4);
			$month=substr($data[5],4,2); if( $year!="0000" && $month="00" ) $month="01";
			$day=substr($data[5],6,2); if( $year!="0000" && $day=="00") $day="01";
			
			$RIR_date="'$year-$month-$day'";
			
		}
		else
		{
			$RIR_date="'".$data[5]."'";
		}

		if( $RIR_date=="'0000-00-00'" ) $RIR_date="NULL";
		
		$type   =$data[6];
		
		$repeat='f';
		$offset=0;
		while( $block_size>0 )
		{
			$prefix=32-floor( log($block_size,2) );
	
			$sql="INSERT INTO ipv4 (on_date,rir,country,ip,is_adhoc,rir_date,type) VALUES(".
			"'$on_date','$rir','$country','$ip_base/$prefix'::inet+$offset,'$repeat',$RIR_date,'$type')";
	
	//		print $sql."\n";
			try {
			$DB->Execute( $sql );
			}
			catch( Exception $e )
			{
				print ".";
//				print $e->getMessage();
			}
			
			$block_size-=pow( 2, 32-$prefix );
			$offset+=pow( 2, 32-$prefix );
	
			$repeat='t';
		}
		
	}
}

?>

