<?php
// $Revision: 13609 $ $Date:: 2020-09-02 #$ $Author: serge $

require_once 'add_random_ride.php';
require_once __DIR__.'/../helper_get_ride.php';
require_once '../credentials_shoppers.php';

$ride_id = NULL;

$res = add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );

if( $res == true )
{
    $resp = NULL;

    $res_2 = \shopndrop_api\get_ride_auto( $host, $port, $login_1, $password, $ride_id, $resp );

    if( $res_2 == true )
    {
        echo "OK: " . \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
    }
    else
    {
        echo "ERROR: " . \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
    }

}

?>
