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
$date1=$argv[1];

$dateTemp=new DateTime( $date1 );
$dateTemp->modify( "1 year" );
$date2=$dateTemp->format( "Y-m-d" );

$type=isset($argv[2])?$argv[2]:"table";

//="count";
$sql1="
select (CASE when plus IS NOT NULL THEN plus ELSE 0 END) as plus,
    (CASE when minus IS NOT NULL THEN minus ELSE 0 END) as minus, 
    countries.name, world_regions.name, world_regions.id as region, 
(CASE when plus.country is null THEN minus.country else plus.country END) as ccc
  FROM
    (select count(*) as plus, country FROM
         (select ip, country from ipv4 where on_date='$date2' group by country, ip 
          except 
          select ip,country from ipv4 where on_date='$date1' group by country, ip) n 
       group by country
    ) plus
full join 
    (select count(*) as minus, country FROM
         (select ip, country from ipv4 where on_date='$date1' group by country, ip 
          except 
          select ip,country from ipv4 where on_date='$date2' group by country, ip) n 
       group by country
    ) minus ON minus.country=plus.country

left join (countries left join world_regions on region = world_regions.id) on code2 = (CASE when plus.country is null THEN minus.country else plus.country END)

--group by countries.name,world_regions.name,world_regions.id
--order by world_regions.id, countries.name
";

$sql2="
order by world_regions.id, countries.name
";

$sql=$sql1." where (CASE when plus.country is null THEN minus.country else plus.country END)='EU' ".$sql2;
$res=$DB->Execute( $sql );
$row=$res->FetchRow();
$eu_plus=$row['plus'];
$eu_minus=$row['minus'];


$sql="SELECT max(plus),max(minus),max(plus-minus) FROM ($sql1 $sql2) test";
$row=$DB->GetRow( $sql );
$max_plus=$row[0];
$max_minus=$row[1];
$max_sum=$row[2];


$i=1;
#$sql=$sql1." and country!='EU' and country!='AP' ".$sql2;
$sql=$sql1.$sql2;
$ret_p="";
$ret_m="";
$ret_t="";

$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
			if( $row['ccc']=='EU' || $row['ccc']=='AP' ) continue;

#			if( $plus==0 ) $plus=1;
#			if( $minus==0 ) $minus=1;

//			print $row[$field]."\n";
		if( is_EU($row['ccc']) ) { $plus+=$eu_plus; $minus+=$eu_minus; }
				//		if( is_AP($row['country']) ) $count+=$eu;
			$plus=$row['plus']>$max_plus?$max_plus:$row['plus'];
			$minus=$row['minus']>$max_minus?$max_minus:$row['minus'];

#		if( $plus>$max_plus ) $plus=$max_plus;
#		if( $minus>$max_minus ) $minus=$max_minus;

		if( $type=="table" )	
		{
				print "$i\t$date1\t$date2\t\"reg-$row[region]\"\t\"$row[ccc]\"\t$plus\t$minus\t".($plus-$minus)."\n";
		}
		else
		{
				if( $plus==0 ) $plus=1;
				if( $minus==0 ) $minus=1;
				#$ret_p.="$max_minus $minus ".(240-240*log($minus,2)/log($max_minus,2))."\n";//, ".(240-240*log($plus+1,2)/$max_plus)."\n";
				$ret_p.="encodedPolygon_$row[ccc].setFillStyle({color:'#".hsb(240-240*log($plus,2)/log($max_plus,2))."',opacity:0.7});\n";
				$ret_m.="encodedPolygon_$row[ccc].setFillStyle({color:'#".hsb(240-240*log($minus,2)/log($max_minus,2))."',opacity:0.7});\n";
				$ret_t.="encodedPolygon_$row[ccc].setFillStyle({color:'#".hsb(240-240*log((($plus-$minus)<=1)?1:($plus-$minus),2)/log($max_sum,2))."',opacity:0.7});\n";
		}
		$i++;	
//		print (240-240*log($count,2)/$max)." = ".$count."\n";
#		print "encodedPolygon_$row[country].setFillStyle({color:'#".hsb(240-240*log($count,2)/$max)."',opacity:0.7});\n";
	}

if( $type=="js" )
{
	print "function plus".str_replace("-","_",$date1)."() {\n";
	print $ret_p;
	print "}\n";

	print "function minus".str_replace("-","_",$date1)."() {\n";
	print $ret_m;
	print "}\n";

	print "function sum".str_replace("-","_",$date1)."() {\n";
	    print $ret_t;
	    print "}\n";
#	die;
}
