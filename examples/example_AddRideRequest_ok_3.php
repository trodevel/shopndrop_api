<?php
// $Revision: 11475 $ $Date:: 2019-05-17 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../helper_add_ride.php';
require_once __DIR__.'/../../shopndrop_protocol/html_helper_web.php';
require_once '../credentials.php';

$error_msg = "";

echo "\n";
echo "TEST: AddRideRequest\n";
{
    // create ride

    $plz = 50668; // Center of Cologne
    $time = \shopndrop_api\time_to_LocalTime( time() + 30 * 60 );   // 30 min from now
    $max_weight     = 3.5; // kg

    $ride_id = NULL;

    $res = \shopndrop_api\add_ride_auto( $host, $port, $login, $password, $plz, $time, $max_weight, $ride_id, $resp );

    if( $res == true )
    {
        echo "OK: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
    }
    else
    {
        echo "ERROR: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
    }
}

?>
