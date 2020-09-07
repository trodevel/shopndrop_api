<?php
// $Revision: 13739 $ $Date:: 2020-09-07 #$ $Author: serge $

require_once 'add_random_ride.php';
require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_web_protocol/html_helper.php';
require_once __DIR__.'/../../basic_objects/object_initializer.php';
require_once '../credentials_shoppers.php';

try
{
    $api = new \shopndrop_api\Api( $host, $port );

    $session_id = NULL;
    $error_msg = NULL;

    $api->open_session( $login_1, $password, $session_id, $error_msg );

    $ride_id = NULL;

    $res = add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );

    if( $res == true )
    {
        $resp = NULL;

        $res_2 = $api->get_ride( $session_id, $ride_id, $resp );

        if( $res_2 == true )
        {
            echo "OK: " . \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
        }
        else
        {
            echo "ERROR: " . \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
        }
    }

    $api->close_session( $session_id, $error_msg );
}
catch( \Exception $e )
{
    echo "FATAL: $e\n";
}

?>
