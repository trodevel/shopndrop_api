<?php
// $Revision: 11264 $ $Date:: 2019-05-11 #$ $Author: serge $

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
        return false;
    }

    return true;
}

?>
