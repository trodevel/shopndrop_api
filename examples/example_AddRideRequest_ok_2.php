<?php
// $Revision: 13732 $ $Date:: 2020-09-06 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_web_protocol/html_helper.php';
require_once __DIR__.'/../../basic_objects/object_initializer.php';
require_once '../credentials.php';

$error_msg = "";

echo "\n";
echo "TEST: AddRideRequest\n";
try
{
    $api = new \shopndrop_api\Api( $host, $port );

    $session_id = NULL;

    $api->open_session( $login, $password, $session_id, $error_msg );

    // create ride

    $plz            = 50668; // Center of Cologne
    $delivery_time  = \shopndrop_api\Api::time_to_LocalTime( time() + 30 * 60 );   // 30 min from now
    $max_weight     = 3.5; // kg

    $ride_id = NULL;

    if( $api->add_ride( $session_id, $plz, $delivery_time, $max_weight, $ride_id, $resp ) == false )
    {
        echo \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
        throw new \Exception( "cannot add ride" );
    }

    echo "ride id = " . $ride_id . "\n\n";

    echo \shopndrop_web_protocol\to_html( $resp ) . "\n\n";

    $api->close_session( $session_id, $error_msg );
}
catch( \Exception $e )
{
    echo "FATAL: $e\n";
}

?>
