<?php

if( $argc<2 )
{
	print "Usage:\n";
	print "		php gen-dates.php <FROM_DATE> <TO_DATE>\n";
	exit( 1 );
}

$date=new DateTime( $argv[1] );
$last=new DateTime( $argv[2] );

for( ; $date<$last; $date->modify( "4 week" ) )
{
		$fdate=$date->format("Y-m-d");
		print "RETURN NEXT '$fdate';\n";
}

