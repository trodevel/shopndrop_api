<?php
// $Revision: 11265 $ $Date:: 2019-05-11 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../helper_add_ride.php';
require_once __DIR__.'/../../shopndrop_protocol/html_helper_web.php';
require_once '../credentials.php';

$error_msg = "";

echo "\n";
echo "TEST: AddRideRequest\n";
{
    $api = new \shopndrop_api\Api( $host, $port );

    $session_id = NULL;

    // open session
    if( $api->open_session( $login, $password, $session_id, $error_msg ) == true )
    {
        echo "OK: opened session\n";

        // create ride

        $plz = 50668; // Center of Cologne
        $time = time() + 30 * 60;   // 30 min from now
        $max_weight     = 3.5; // kg

        $ride_id = NULL;

        $res = \shopndrop_api\add_ride( $api, $session_id, $plz, $time, $max_weight, $ride_id, $resp );

        if( $res == true )
        {
            echo "OK: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
        }
        else
        {
            echo "ERROR: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
        }

        // close session
        if( $api->close_session( $session_id, $error_msg ) == true )
        {
            echo "OK: session closed\n";
        }
        else
        {
            echo "ERROR: cannot close session: $error_msg\n";
        }
    }
    else
    {
        echo "ERROR: cannot open session: $error_msg\n";
    }
}

?>
