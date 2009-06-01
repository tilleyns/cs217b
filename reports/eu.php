<?php

$EU=array(
		'AT',
		'BE',
		'BG',
		'CY',
		'CZ',
		'DK',
		'EE',
		'FI',
		'FR',
		'DE',
		'GR',
		'HU',
		'IE',
		'IT',
		'LV',
		'LT',
		'LU',
		'MT',
		'NL',
		'PL',
		'PT',
		'RO',
		'SK',
		'SI',
		'ES',
		'SE',
		'GB',
	);

function is_EU( $country )
{
		global $EU;
		return in_array( $country, $EU );
}

$AP=array(
		'BW',
		'GM',
		'GH',
		'KE',
		'LS',
		'MW',
		'MZ',
		'NA',
		'SL',
		'SO',
		'SD',
		'SZ',
		'TZ',
		'UG',
		'ZM',
		'ZW',
);

function is_AP( $country )
{
		global $AP;
		return in_array( $country, $AP );
}
?>
