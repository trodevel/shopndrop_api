<?php
// $Revision: 11422 $ $Date:: 2019-05-14 #$ $Author: serge $

namespace shopndrop_api;

require_once __DIR__.'/api.php';

function add_order( & $api, $session_id, $ride_id, $shopping_list, $delivery_address, & $order_id, & $resp )
{
    // execute request

    $req = new \shopndrop_protocol\AddOrderRequest( $session_id, $ride_id, $shopping_list, $delivery_address );

    $resp = $api->submit( $req );

    if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
    {
        return false;
    }
    elseif( get_class( $resp ) == "shopndrop_protocol\AddOrderResponse" )
    {
        $order_id = $resp->order_id;
    }
    else
    {
        $new_resp = new \generic_protocol\ErrorResponse( \generic_protocol\ErrorResponse::RUNTIME_ERROR, "unknown response: " . get_class( $resp ) );

        $resp = $new_resp;

        return false;
    }

    return true;
}

function add_order_auto( $host, $port, $login, $password, $ride_id, $shopping_list, $delivery_address, & $order_id, & $resp )
{
    $api = new \shopndrop_api\Api( $host, $port );

    $error_msg = NULL;
    $session_id = NULL;

    // open session
    if( $api->open_session( $login, $password, $session_id, $error_msg ) == true )
    {
        $res = add_order( $api, $session_id, $ride_id, $shopping_list, $delivery_address, $order_id, $resp );

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
