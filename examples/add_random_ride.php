<?php
// $Revision: 11332 $ $Date:: 2019-05-13 #$ $Author: serge $

require_once __DIR__.'/../helper_add_ride.php';
require_once __DIR__.'/../../shopndrop_protocol/html_helper_web.php';

function add_random_ride( $host, $port, $login, $password, $plz_base, $delay_base, $max_weight_base, & $ride_id )
{
    $plz        = $plz_base + rand( 0, 100 ) * 20;
    $time       = time() + ( $delay_base + rand( 0, 10 ) * 15 ) * 60;
    $max_weight = $max_weight_base + rand( 0, 5 ) * .5; // kg

    $resp    = NULL;

    $res = \shopndrop_api\add_ride_auto( $host, $port, $login, $password, $plz, $time, $max_weight, $ride_id, $resp );

    if( $res == true )
    {
        echo "OK: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
    }
    else
    {
        echo "ERROR: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
    }

    return $res;
}

?>
