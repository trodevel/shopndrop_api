<?php
// $Revision: 11424 $ $Date:: 2019-05-14 #$ $Author: serge $

namespace shopndrop_api;

require_once __DIR__.'/api.php';

function get_dash_screen_shopper( & $api, $session_id, $user_id, $plz, & $resp )
{
    // execute request

    $position = \shopndrop_protocol\GeoPosition::withPlz( $plz );

    $req = new \shopndrop_protocol\web\GetDashScreenshopperRequest( $session_id, $user_id, $position );

    $resp = $api->submit( $req );

    if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
    {
        return false;
    }
    elseif( get_class( $resp ) == "shopndrop_protocol\web\GetDashScreenShopperResponse" )
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

function get_dash_screen_shopper_auto( $host, $port, $login, $password, $plz, & $resp )
{
    $api = new \shopndrop_api\Api( $host, $port );

    $error_msg = NULL;
    $session_id = NULL;

    // open session
    if( $api->open_session( $login, $password, $session_id, $error_msg ) == true )
    {
        $user_id = 1;

        $res = get_dash_screen_shopper( $api, $session_id, $user_id, $plz, $resp );

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
