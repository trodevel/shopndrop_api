<?php
// $Revision: 11266 $ $Date:: 2019-05-11 #$ $Author: serge $

namespace shopndrop_api;

require_once __DIR__.'/api.php';

function add_ride( & $api, $session_id, $plz, $time, $max_weight, & $ride_id, & $resp )
{
    $position       = \shopndrop_protocol\GeoPosition::withPlz( $plz );

    $now_plus_delay = localtime( $time, true );
    $delivery_time  = new \basic_objects\LocalTime( $now_plus_delay["tm_year"] + 1900, $now_plus_delay["tm_mon"] + 1, $now_plus_delay["tm_mday"],     $now_plus_delay["tm_hour"], $now_plus_delay["tm_min"], $now_plus_delay["tm_sec"] );

    $ride = new \shopndrop_protocol\Ride( $position, $delivery_time, $max_weight );

    // execute request

    $req = new \shopndrop_protocol\AddRideRequest( $session_id, $ride );

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
        return false;
    }

    return $res;
}

?>
