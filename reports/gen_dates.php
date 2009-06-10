<?php

#if( $argc<2 )
#{
#	print "Usage:\n";
#	print "		php gen-dates.php <FROM_DATE> <TO_DATE>\n";
#	exit( 1 );
#}

$dates=array(
		array("from"=>"2003-01-01", "to"=>"2004-01-01"),
		array("from"=>"2004-01-01", "to"=>"2005-01-01"),
		array("from"=>"2005-01-01", "to"=>"2006-01-01"),
		array("from"=>"2006-01-01", "to"=>"2007-01-01"),
		array("from"=>"2007-01-01", "to"=>"2008-01-01"),
		array("from"=>"2008-01-01", "to"=>"2009-01-01"),
		array("from"=>"2009-01-01", "to"=>"2009-05-04"),
		);

print "<?php\n".'$DATES='."array(\n";
foreach( $dates as $a )
{
	$date=new DateTime( $a["from"] );
	$last=new DateTime( $a["to"] );

	for( ; $date<$last; $date->modify( "4 week" ) )
	{
		$fdate=$date->format("Y-m-d");
		$temp=new DateTime( $fdate ); $temp->modify( "4 week" );
		$ftemp=$temp->format("Y-m-d");

		print "select '$fdate'::date,'$ftemp'::date INTO ret;return next ret;\n";
	}
}

print ");\n?>\n";

