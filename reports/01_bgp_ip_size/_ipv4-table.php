<?php

#include( "../dates.php" );
include( "../hsb.php" );
include( "../eu.php" );
include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );

$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

print "#Date\tCountryCode\tCountry\t#allocations\t#ipSpace\tratio\n";
#foreach( $DATES as $date )
$date=$argv[1];

//="count";

	$sql1=
"
select r.name as region,i.country,c.name,count,size,ratio,
	to_char(count/old_count,'99.99') as ratio_count,
	to_char(size/old_size,'99.99')   as ratio_size
   from ( select country,sum(count) as count ,
    sum(size) as size, sum(size)/sum(count) as ratio from ipv4_counts_country 
	where on_date='$date' 
	group by country) i
left join countries c on i.country=c.code2
left join world_regions r on c.region=r.id

left join ( select country,sum(count) as old_count ,
               sum(size) as old_size, sum(size)/sum(count) as old_ratio from ipv4_counts_country 
			where on_date='2003-01-01' 
			group by country) o ON i.country=o.country
--order by count desc

/*select r.name as region,country,c.name,sum(count) as count ,
		sum(size) as size, sum(size)/sum(count) as ratio 
	from (select * from ipv4_counts_country where on_date='$date') i
	right join countries c on i.country=c.code2
	right join world_regions r on c.region=r.id

--	left join (select 
where on_date='$date'*/
";

$sql2="
--group by country,c.name,c.region,r.name
order by size desc
limit 30
--order by c.region,r.name,country
";

/*$sql=$sql1." and country='EU' ".$sql2;
$res=$DB->Execute( $sql );
$row=$res->FetchRow();
$eu_count=$row['count'];
$eu_size=$row['size'];
 */
$i=1;
//$sql=$sql1." and country!='EU' and country!='AP' ".$sql2;
$sql=$sql1.$sql2;
print $sql."\n";
$res=$DB->Execute( $sql );
	foreach( $res as $row )
	{
			$count=$row['count'];
			$size=$row['size'];
//			print $row[$field]."\n";
//		if( is_EU($row['country']) ) { $count+=$eu_count; $size+=$eu_size; }
//		if( is_AP($row['country']) ) $count+=$eu;
		
				//print "$i\t$date\t\"$row[region]\"\t\"$row[country]\"\t$count\t$size\t".($size/$count)."\n";
			print "$i\t&\t$row[name]\t&\t".number_format($count)."\t&\t".number_format($size).//"\t\\tabularnewline\n";
					"\t&\t$row[ratio_size]\t\\tabularnewline\n";
		$i++;	
//		print (240-240*log($count,2)/$max)." = ".$count."\n";
#		print "encodedPolygon_$row[country].setFillStyle({color:'#".hsb(240-240*log($count,2)/$max)."',opacity:0.7});\n";
	}

#	die;

