<?php
/**
 * This function can round a float or number by $precision digitst, taking in account the digits before te decimal point.
 *
 * @param int|float $number The number that needs to be rounded
 * @param int $precision The number of digits to wich $number needs to be rounded.
 * @return float
 */
function significantRound($number, $precision) {
    if (!is_numeric($number)) {
        throw new InvalidArgumentException('Argument $number must be an number.');
    }
    if (!is_int($precision)) {
        throw new InvalidArgumentException('Argument $precision must be an integer.');
    }
    return round($number, $precision - strlen(floor($number)));
}
/**
 * This function converts an color defined in the HSB/HSV color space to the equivalent colordefinition in the RGB color space.
 *
 * @uses significantRound()
 * @param float|int $hue This parameter can be a integer or float between 0 and 360. Note that is makes no sense to pass through a float with more than three digits, because it is rounded at three digits.
 * @param float|int $saturation This parameter can be a integer or float between 0 and 100. Note that is makes no sense to pass through a float with more than three digits, because it is rounded at three digits.
 * @param float|int $brightness This paramater can be a integer or float between 0 and 100. Note that it makes no sense to pass through a float with more than trhee digits, because it is rounded at three digits.
 * @return array|boolean On succes, this function returns an array with elements 'red' 'green' and 'blue', containing integers with a range from 0 to 255. On failure this function returns false.
 */
function hsbToRgb($hue, $saturation, $brightness) {
    $hue = significantRound($hue, 3);
    if ($hue < 0 || $hue > 360) {
        throw new LengthException('Argument $hue is not a number between 0 and 360');
    }
    $hue = $hue == 360 ? 0 : $hue;
    $saturation = significantRound($saturation, 3);
    if ($saturation < 0 || $saturation > 100) {
        throw new LengthException('Argument $saturation is not a number between 0 and 100');
    }
    $brightness = significantRound($brightness, 3);
    if ($brightness < 0 || $brightness > 100) {
        throw new LengthException('Argument $brightness is not a number between 0 and 100.');
    }
    $hexBrightness = (int) round($brightness * 2.55);
    if ($saturation == 0) {
        return array('red' => $hexBrightness, 'green' => $hexBrightness, 'blue' => $hexBrightness);
    }
    $Hi = floor($hue / 60);
    $f = $hue / 60 - $Hi;
    $p = (int) round($brightness * (100 - $saturation) * .0255);
    $q = (int) round($brightness * (100 - $f * $saturation) * .0255);
    $t = (int) round($brightness * (100 - (1 - $f) * $saturation) * .0255);
    switch ($Hi) {
        case 0:
            return array('red' => $hexBrightness, 'green' => $t, 'blue' => $p);
        case 1:
            return array('red' => $q, 'green' => $hexBrightness, 'blue' => $p);
        case 2:
            return array('red' => $p, 'green' => $hexBrightness, 'blue' => $t);
        case 3:
            return array('red' => $p, 'green' => $q, 'blue' => $hexBrightness);
        case 4:
            return array('red' => $t, 'green' => $p, 'blue' => $hexBrightness);
        case 5:
            return array('red' => $hexBrightness, 'green' => $p, 'blue' => $q);
    }
    return false;
}
?>
