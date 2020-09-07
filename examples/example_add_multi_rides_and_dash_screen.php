<?php
// $Revision: 13737 $ $Date:: 2020-09-07 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_web_protocol/html_helper.php';
require_once __DIR__.'/../../basic_objects/object_initializer.php';
require_once 'add_random_ride.php';
require_once '../credentials_shoppers.php';

try
{
    $ride_id = NULL;

    add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
    #add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
    #add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
    #add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
    #add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
    #add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
    #add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
    #add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );

    $api = new \shopndrop_api\Api( $host, $port );

    $session_id = NULL;
    $error_msg = NULL;

    $api->open_session( $login_1, $password, $session_id, $error_msg );

    $user_id = NULL;

    $api->get_user_id( $session_id, $login_1, $user_id, $error_msg );

    $resp = NULL;

    $res = $api->get_dash_screen_user( $session_id, $user_id, 50668, $resp );

    $res_type = "OK";

    if( $res == false )
    {
        $res_type = "ERROR";
    }

    echo "$res_type: " . \shopndrop_web_protocol\to_html( $resp ) . "\n\n";

    $api->close_session( $session_id, $error_msg );
}
catch( \Exception $e )
{
    echo "FATAL: $e\n";
}

?>
