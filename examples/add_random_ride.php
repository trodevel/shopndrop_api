<?php
// $Revision: 13735 $ $Date:: 2020-09-07 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_web_protocol/html_helper.php';
require_once __DIR__.'/../../basic_objects/object_initializer.php';

function add_random_ride( $host, $port, $login, $password, $plz_base, $delay_base, $max_weight_base, & $ride_id )
{
    $api = new \shopndrop_api\Api( $host, $port );

    $session_id = NULL;

    $error_msg = NULL;

    $api->open_session( $login, $password, $session_id, $error_msg );

    $plz            = $plz_base + rand( 0, 100 ) * 20;
    $delivery_time  = \shopndrop_api\Api::time_to_LocalTime( time() + ( $delay_base + rand( 0, 10 ) * 15 ) * 60 );
    $max_weight     = $max_weight_base + rand( 0, 5 ) * .5; // kg

    $resp    = NULL;

    $res = $api->add_ride( $session_id, $plz, $delivery_time, $max_weight, $ride_id, $resp );

    if( $res == true )
    {
        echo "OK: " . \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
    }
    else
    {
        echo "ERROR: " . \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
    }

    $api->close_session( $session_id, $error_msg );

    return $res;
}

?>
