<?php

#include( "../dates.php" );

#print "#Date\tCountryCode\tCountry\t#allocations\t#ipSpace\tratio\n";
#foreach( $DATES as $date )
$date1=$argv[1];

$dateTemp=new DateTime( $date1 );

$date1=$dateTemp->format( "Y" );
$dateTemp->modify( "1 year" );

$date2=$dateTemp->format( "Y" );

system( "cat plus_minus_scatter_t.plt | sed -e 's/(YEAR)/($date1 - $date2)/g' > plus_minus_scatter.plt" );

?>
