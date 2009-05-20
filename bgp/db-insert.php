<?php

define( "BASEDIR", dirname(__FILE__) );

include_once( BASEDIR."/../scripts/adodb/adodb-exceptions.inc.php" );
include_once( BASEDIR."/../scripts/adodb/adodb.inc.php" );
$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );
if( !$DB ) 
{
	print "Error\n";
	exit;
}

if( $argc<3 )
{
	print "Usage:\n";
	print "		php db-insert.php <SOURCE> <FROM_DATE> <TO_DATE>\n";
	exit( 1 );
}

$source=$argv[1];

while( !isset($source_id) )
{
	$source_id=$DB->GetOne( "SELECT id FROM bgp_sources WHERE \"name\"=".$DB->qstr($source) );
	if( !$source_id ) //nothing
	{
			$DB->Execute( "INSERT INTO bgp_sources (name) VALUES(".$DB->qstr($source).")" );
	}
}

$date=new DateTime( $argv[2] );
$last=new DateTime( $argv[3] );

for( ; $date<$last; $date->modify( "4 week" ) )
{
	$fdate=$date->format("Y-m-d");
	if( !is_file("$source-$fdate.bz2") )
	{
			print "File [$source-$fdate.bz2] must be in current directory\n";
			continue;
	}
	print "[$fdate]\n";
	print ">> ".date( "h:i:s a" )."\n";
	$file=popen( "bzip2 -dc $source-$fdate.bz2", "r" );

	insert_db( $file, $fdate );

	pclose( $file );
	print "<< ".date( "h:i:s a" )."\n";
}

function insert_db( $file, $date )
{
		global $DB, $source, $source_id;

		$DB->BeginTrans(); 
		while( !feof($file) )
		{
				$prefix=trim( fgets($file) );

				if( $prefix=="0.0.0.0/0" || $prefix=="" || strpos($prefix, ":")>0 || $prefix=="::/0" || $prefix=="0.0.0.0/1" || $prefix=='128.0.0.0/1' ) continue;
				$DB->Execute( "INSERT INTO bgp (ip,size,source,on_date) VALUES(
						'$prefix'::ip4r,ip4r_size('$prefix'::ip4r),'$source_id','$date')" );
		}
		$DB->CommitTrans();
}

