<?php
// $Revision: 11412 $ $Date:: 2019-05-14 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_protocol/html_helper_web.php';
require_once '../credentials.php';

$error_msg = "";

$user_id = 0;

echo "\n";
echo "TEST: GetDashScreenUserRequest\n";
{
    $api = new \shopndrop_api\Api( $host, $port );

    $session_id = NULL;

    // open session
    if( $api->open_session( $login, $password, $session_id, $error_msg ) == true )
    {
        echo "OK: opened session\n";

        // get user ID
        $req = new \generic_protocol\GetUserIdRequest( $session_id, $login );

        echo "REQ = " . $req->to_generic_request() . "\n";
        $resp = $api->submit( $req );
        echo "user id = " . $resp->user_id . "\n\n";
        $user_id = $resp->user_id;

        $position = \shopndrop_protocol\GeoPosition::withPlz( 50668 );

        // execute request
        {
            $req = new \shopndrop_protocol\web\GetDashScreenUserRequest( $session_id, $user_id, $position );

            echo "REQ = " . $req->to_generic_request() . "\n";
            $resp = $api->submit( $req );

            if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
            {
                echo "ERROR: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
            }
            elseif( get_class( $resp ) == "shopndrop_protocol\web\GetDashScreenUserResponse" )
            {
                echo "OK: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
            }
            else
            {
                echo "ERROR: unknown response: " . get_class( $resp ) . "\n\n";
            }
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