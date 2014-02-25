<?php
function getLocation($destination_string)
{
    $geocode_url = "http://maps.googleapis.com/maps/api/geocode/json?address=";
    $REST_GEOCODE_URL = $geocode_url . urlencode(preg_replace('/\([^)]*\)/', '', $destination_string)) . "&sensor=false";
    echo '<a href="' . $REST_GEOCODE_URL . '" target="_blank">' . $REST_GEOCODE_URL . '</a>';
    
    $ch_geocode = curl_init();
    curl_setopt($ch_geocode, CURLOPT_URL, $REST_GEOCODE_URL);
    curl_setopt($ch_geocode, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_geocode, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Accept-Encoding: application/json',
    ));
    $geocode_response = curl_exec($ch_geocode);
    $geocode_response = json_decode($geocode_response);
    
    return $geocode_response;
}
?>
<form name="geocode">
<label for="destination_string">Destination String</label>
<input name="destination_string" id="destination_string" type="text" value="<?php echo isset($_REQUEST['destination_string']) ? $_REQUEST['destination_string'] : '' ?>" />
<input type="submit" />
</form>
<?php

if( $_REQUEST ) {
    $data = getLocation($_REQUEST['destination_string']);
    if( $data->status === 'OK' ) {
        echo '<br /><pre>'.print_r($data->results[0]->geometry->location, true).'</pre>';
    } else {
        echo 'Geocode failed to locate venue location';
    }
}