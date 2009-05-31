<?php

include( "../dates.php" );
include( "../eu.php" );
include( "../hsb.php" );
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

$date=$argv[1];
$type=(isset($argv[2]))?$argv[2]:"table";

if( $type=="table" ) print "#Date\t#announcements\t#ipSpace\tratio\n";

$row=$DB->GetRow( "SELECT max(size),max(count) FROM bgp_counts_countries where on_date='2009-04-23' and source='3'" );
$max_size=log($row[0],2);
$max_count=log($row[1],2);

$sql1=
"select r.name as region,country,c.name,s.id as sid,s.name as source, count, size from bgp_counts_countries  i
		left join countries c on i.country=c.code2
		left join world_regions r on c.region=r.id
		left join bgp_sources s on s.id=i.source
		where source=3 and on_date='$date'";

$sql2="
		order by c.region,country,s.id
		";

$sql=$sql1." and country='EU' ".$sql2;
$res=$DB->Execute( $sql );
$eu=array();
foreach( $res as $row )
{
	$eu[$row['sid']]=array(
			"count"=>$row['count'],
			"size" =>$row['size'],
	);
}

$i=0;
$sql=$sql1." and ((country!='EU' and country!='AP') or country is NULL) ".$sql2;
$res=$DB->Execute( $sql );
$ret_s="";
$ret_c="";
$prevCountry="";
	foreach( $res as $row )
	{
			if( $row['country']=='UK' ) $row['country']='GB';
			if( $prevCountry!=$row['country'] )
			{
					$prevCountry=$row['country'];
					$i++;
			}

			$count=$row['count'];
			$size=$row['size'];
			if( is_EU($row['country']) ) 
			{
					$count+=$eu[$row['sid']]['count'];
					$size+=$eu[$row['sid']]['size']; 
			}
			
			if( $type=="table" )
			{
				print "$i\t$date\t\"$row[region]\"\t\"$row[country]\"\t$row[source]\t$count\t$size\t".($size/$count)."\n";
			}
			else if( $type=="js" )
			{
					if( "$row[country]"=="" ) continue;
					#print (240-240*log($size,2)/$max_size)."\n";
					#print "$size, $count,  $max_size/$max_count\n";
				$ret_s.="encodedPolygon_$row[country].setFillStyle({color:'#".hsb(240-240*log($size,2)/$max_size)."',opacity:0.7});\n";
				$ret_c.="encodedPolygon_$row[country].setFillStyle({color:'#".hsb(240-240*log($count,2)/$max_count)."',opacity:0.7});\n";
			}

	}

if( $type=="js" )
{
		print "function size".str_replace("-","_",$date)."() {\n";
		print $ret_s;
		print "}\n\n";

		print "function count".str_replace("-","_",$date)."() {\n";
		print $ret_c;
		print "}\n";
}

?>
