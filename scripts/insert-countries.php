<?php

include_once( "adodb/adodb-exceptions.inc.php" );
include_once( "adodb/adodb.inc.php" );
$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );
if( !$DB ) 
{
	print "Error\n";
	exit;
}

$file=fopen( 'php://stdin', 'r' );
while( !feof($file) )
{
		$string=trim(fgets( $file, 4096 ));

		if( preg_match("/^(.+)\s+(\S\S)\s+(\S\S\S)\s+(\S\S\S)$/", $string, $matches) )
		{
#				print "$matches[2] = $matches[1]\n";
				$DB->Execute( "INSERT INTO countries (code2,code3,code_num,name) values('$matches[2]','$matches[3]','$matches[4]',".$DB->qstr($matches[1]).")" );
		}
}

fclose( $file );

?>	
