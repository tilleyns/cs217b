<?php

#include( "../dates.php" );
include( "../hsb.php" );
include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

function dechex1( $dec )
{
	$ret=dechex( $dec );
	return (strlen($dec)<2?"0":"").$ret;
}

function hsb( $color )
{
		if( $color>360 ) $color=360;
	$value=hsbToRgb( $color,100,100 );
	return dechex1($value['red']).dechex1($value['green']).dechex1($value['blue']);
}
		
#print "#Date\tCountryCode\tCountry\t#allocations\t#ipSpace\tratio\n";
#foreach( $DATES as $date )
$date=$argv[1];

print "function $argv[2]() {\n";
{
	$max=$DB->GetOne( "SELECT max(count) FROM
			(select sum(size) as count from ipv4_counts_country where on_date='$date' group by country) d" );

	$max=log($max,2);
#	print $max;

	$sql=
"
select country,name,sum(count) as count ,sum(size) as size, sum(size)/sum(count) as ratio from ipv4_counts_country  i
right join countries c on i.country=c.code2
where on_date='$date'
group by country,name
order by size desc
";
	$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
		#print "$date\t$row[country]\t$row[name]\t$row[count]\t$row[size]\t$row[ratio]\n";
		print "encodedPolygon_$row[country].setFillStyle({color:'#".hsb(240-240*log($row['size'],2)/$max)."',opacity:0.7});\n";
	}

#	die;
}

print "}\n";

