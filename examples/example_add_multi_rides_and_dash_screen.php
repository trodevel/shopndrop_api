<?php
// $Revision: 11332 $ $Date:: 2019-05-13 #$ $Author: serge $

require_once 'add_random_ride.php';
require_once __DIR__.'/../helper_get_dash_screen_user.php';
require_once '../credentials_shoppers.php';

$ride_id = NULL;

add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
#add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
#add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
#add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
#add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
#add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
#add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
#add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );

$resp = NULL;

$res = \shopndrop_api\get_dash_screen_user_auto( $host, $port, $login_1, $password, $resp );

    if( $res == true )
    {
        echo "OK: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
    }
    else
    {
        echo "ERROR: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
    }

?>
