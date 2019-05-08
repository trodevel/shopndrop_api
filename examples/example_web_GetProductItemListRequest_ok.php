<?php
// $Revision: 11135 $ $Date:: 2019-05-08 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_protocol/html_helper_web.php';
require_once '../credentials.php';

$error_msg = "";

$user_id = 0;

echo "\n";
echo "TEST: GetProductItemListRequest\n";
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

        // execute request
        {
            $req = new \shopndrop_protocol\web\GetProductItemListRequest( $session_id );

            echo "REQ = " . $req->to_generic_request() . "\n";
            $resp = $api->submit( $req );

            if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
            {
                echo "ERROR: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
            }
            elseif( get_class( $resp ) == "shopndrop_protocol\web\GetProductItemListResponse" )
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
