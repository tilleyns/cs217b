<?php

#include( "../dates.php" );
include( "../hsb.php" );
include( "../eu.php" );
include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

function dechex1( $dec )
{
	$ret=dechex( $dec );
	if( $dec<16 ) return "0".$ret;
	return $ret;
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

$field=$argv[3];
//="count";

print "function $argv[2]() {\n";
{
	$max=$DB->GetOne( "SELECT max($field) FROM
			(select sum($field) as $field from ipv4_counts_country where on_date='2009-04-23' group by country) d" );

	$max=log($max,2);
#	print $max;

	$sql1=
"
select country,name,sum(count) as count ,sum(size) as size, sum(size)/sum(count) as ratio from ipv4_counts_country  i
right join countries c on i.country=c.code2
where on_date='$date'
";

$sql2="
group by country,name
order by size desc
";

$sql=$sql1." and country='EU' ".$sql2;
$res=$DB->Execute( $sql );
$row=$res->FetchRow();
$eu=$row[$field];

$sql=$sql1." and country='AP' ".$sql2;
$res=$DB->Execute( $sql );
$row=$res->FetchRow();
$ap=$row[$field];

$sql=$sql1." and country!='EU' and country!='AP' ".$sql2;
$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
			$count=$row[$field];
//			print $row[$field]."\n";
		if( is_EU($row['country']) ) $count+=$eu;
//		if( is_AP($row['country']) ) $count+=$eu;
		
		#print "$date\t$row[country]\t$row[name]\t$row[count]\t$row[size]\t$row[ratio]\n";
//		print (240-240*log($count,2)/$max)." = ".$count."\n";
		print "encodedPolygon_$row[country].setFillStyle({color:'#".hsb(240-240*log($count,2)/$max)."',opacity:0.7});\n";
	}

#	die;
}

print "}\n";

