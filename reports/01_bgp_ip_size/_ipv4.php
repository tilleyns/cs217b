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

//="count";

	$row=$DB->GetRow( "SELECT max(size),max(count) FROM
			(select sum(size) as size, sum(count) as count from ipv4_counts_country where on_date='2009-04-23' group by country) d" );

$max_size=log( $row[0],2 );
$max_count=log( $row[1],2 );

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

   $eu=array(
         "count"=>$row['count'],
         "size" =>$row['size'],
   );

$ret_c="";
$ret_s="";
$sql=$sql1." and country!='EU' and country!='AP' ".$sql2;
$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
			$count=$row['count'];
			$size=$row['size'];
			if( is_EU($row['country']) ) 
			{
					$count+=$eu['count'];
					$size+=$eu['size'];
			}
		
			$ret_c.="encodedPolygon_$row[country].setFillStyle({color:'#".hsb(240-240*log($count,2)/$max_count)."',opacity:0.7});\n";
			$ret_s.="encodedPolygon_$row[country].setFillStyle({color:'#".hsb(240-240*log($size,2)/$max_size)."',opacity:0.7});\n";
	}

print "function size".str_replace("-","_",$date)."() {\n";
print $ret_s;
print "}\n";

print "function count".str_replace("-","_",$date)."() {\n";
print $ret_c;
print "}\n";

