<?php
// $Revision: 11512 $ $Date:: 2019-05-17 #$ $Author: serge $

namespace shopndrop_api;

require_once __DIR__.'/api.php';

function get_shopping_list_with_totals( & $api, $session_id, $shopping_list_id, & $resp )
{
    // execute request

    $req = new \shopndrop_protocol\web\GetShoppingListWithTotalsRequest( $session_id, $shopping_list_id );

    $resp = $api->submit( $req );

    if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
    {
        return false;
    }
    elseif( get_class( $resp ) == "shopndrop_protocol\web\GetShoppingListWithTotalsResponse" )
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

function get_shopping_list_with_totals_auto( $host, $port, $login, $password, $shopping_list_id, & $resp )
{
    $api = new \shopndrop_api\Api( $host, $port );

    $error_msg = NULL;
    $session_id = NULL;

    // open session
    if( $api->open_session( $login, $password, $session_id, $error_msg ) == true )
    {
        $res = get_shopping_list_with_totals( $api, $session_id, $shopping_list_id, $resp );

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