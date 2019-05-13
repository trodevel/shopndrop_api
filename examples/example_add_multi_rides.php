<?php
// $Revision: 11332 $ $Date:: 2019-05-13 #$ $Author: serge $

require_once 'add_random_ride.php';
require_once '../credentials_shoppers.php';

$ride_id = NULL;

add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );
add_random_ride( $host, $port, $login_2, $password, 50668, 30, 2, $ride_id );
add_random_ride( $host, $port, $login_3, $password, 50668, 30, 2, $ride_id );
add_random_ride( $host, $port, $login_4, $password, 50668, 30, 2, $ride_id );
add_random_ride( $host, $port, $login_5, $password, 50668, 30, 2, $ride_id );
add_random_ride( $host, $port, $login_6, $password, 50668, 30, 2, $ride_id );
add_random_ride( $host, $port, $login_7, $password, 50668, 30, 2, $ride_id );
add_random_ride( $host, $port, $login_8, $password, 50668, 30, 2, $ride_id );

?>
