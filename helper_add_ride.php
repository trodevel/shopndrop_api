<?php
// $Revision: 11474 $ $Date:: 2019-05-17 #$ $Author: serge $

namespace shopndrop_api;

require_once __DIR__.'/api.php';

function time_to_LocalTime( $time )
{
    $localtime  = localtime( $time, true );
    $res        = new \basic_objects\LocalTime(
            $localtime["tm_year"] + 1900,
            $localtime["tm_mon"] + 1,
            $localtime["tm_mday"],
            $localtime["tm_hour"],
            $localtime["tm_min"],
            $localtime["tm_sec"] );

    return $res;
}

function add_ride( & $api, $session_id, $plz, $delivery_time, $max_weight, & $ride_id, & $resp )
{
    $position       = \shopndrop_protocol\GeoPosition::withPlz( $plz );

    $ride_summary   = new \shopndrop_protocol\RideSummary( $position, $delivery_time, $max_weight );

    // execute request

    $req = new \shopndrop_protocol\AddRideRequest( $session_id, $ride_summary );

    $resp = $api->submit( $req );

    if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
    {
        return false;
    }
    elseif( get_class( $resp ) == "shopndrop_protocol\AddRideResponse" )
    {
        $ride_id = $resp->ride_id;
    }
    else
    {
        $new_resp = new \generic_protocol\ErrorResponse( \generic_protocol\ErrorResponse::RUNTIME_ERROR, "unknown response: " . get_class( $resp ) );

        $resp = $new_resp;

        return false;
    }

    return true;
}

function add_ride_auto( $host, $port, $login, $password, $plz, $time, $max_weight, & $ride_id, & $resp )
{
    $api = new \shopndrop_api\Api( $host, $port );

    $error_msg = NULL;
    $session_id = NULL;

    // open session
    if( $api->open_session( $login, $password, $session_id, $error_msg ) == true )
    {
        $res = add_ride( $api, $session_id, $plz, $time, $max_weight, $ride_id, $resp );

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
