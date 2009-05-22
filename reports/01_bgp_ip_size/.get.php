<?php

require_once( "adodb/adodb-exceptions.inc.php" );
require_once( "adodb/adodb.inc.php" );
$DB=&NewADOConnection( "postgres://postgres:@localhost/ip_stat?persist" );

$res=$DB->Execute( "" );

