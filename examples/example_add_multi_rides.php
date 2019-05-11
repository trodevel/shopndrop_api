<?php
// $Revision: 11270 $ $Date:: 2019-05-11 #$ $Author: serge $

require_once __DIR__.'/../helper_add_ride.php';
require_once __DIR__.'/../../shopndrop_protocol/html_helper_web.php';
require_once '../credentials_shoppers.php';

function add_ride( $host, $port, $login, $password, $plz_base, $delay_base, $max_weight_base )
{
    $plz        = $plz_base + rand( 0, 100 ) * 20;
    $time       = time() + ( $delay_base + rand( 0, 10 ) * 15 ) * 60;
    $max_weight = $max_weight_base + rand( 0, 5 ) * .5; // kg

    $ride_id = NULL;
    $resp    = NULL;

    $res = \shopndrop_api\add_ride_auto( $host, $port, $login, $password, $plz, $time, $max_weight, $ride_id, $resp );

    if( $res == true )
    {
        echo "OK: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
    }
    else
    {
        echo "ERROR: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
    }
}

add_ride( $host, $port, $login_1, $password, 50668, 30, 2 );
add_ride( $host, $port, $login_2, $password, 50668, 30, 2 );
add_ride( $host, $port, $login_3, $password, 50668, 30, 2 );
add_ride( $host, $port, $login_4, $password, 50668, 30, 2 );
add_ride( $host, $port, $login_5, $password, 50668, 30, 2 );
add_ride( $host, $port, $login_6, $password, 50668, 30, 2 );
add_ride( $host, $port, $login_7, $password, 50668, 30, 2 );
add_ride( $host, $port, $login_8, $password, 50668, 30, 2 );

?>
