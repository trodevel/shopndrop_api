<?php
// $Revision: 11529 $ $Date:: 2019-05-20 #$ $Author: serge $

namespace shopndrop_api;

require_once __DIR__.'/api.php';

function mark_delivered_order( & $api, $session_id, $order_id, & $resp )
{
    // execute request

    $req = new \shopndrop_protocol\MarkDeliveredOrderRequest( $session_id, $order_id );

    $resp = $api->submit( $req );

    if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
    {
        return false;
    }
    elseif( get_class( $resp ) == "shopndrop_protocol\MarkDeliveredOrderResponse" )
    {
    }
    else
    {
        $new_resp = new \generic_protocol\ErrorResponse( \generic_protocol\ErrorResponse::RUNTIME_ERROR, "unknown response: " . get_class( $resp ) );

        $resp = $new_resp;

        return false;
    }

    return true;
}

function mark_delivered_order_auto( $host, $port, $login, $password, $order_id, & $resp )
{
    $api = new \shopndrop_api\Api( $host, $port );

    $error_msg = NULL;
    $session_id = NULL;

    // open session
    if( $api->open_session( $login, $password, $session_id, $error_msg ) == true )
    {
        $res = mark_delivered_order( $api, $session_id, $order_id, $resp );

        if( $api->close_session( $session_id, $error_msg ) == true )
        {
            //echo "OK: session closed\n";
        }
        else
        {
            //echo "ERROR: cannot close session: $error_msg\n";
        }
    }
    else
    {
        $resp = new \generic_protocol\ErrorResponse( \generic_protocol\ErrorResponse::RUNTIME_ERROR, "cannot open session: " . $error_msg );

        return false;
    }

    return $res;
}

?>
