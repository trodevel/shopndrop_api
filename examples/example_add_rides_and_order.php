<?php
// $Revision: 11425 $ $Date:: 2019-05-14 #$ $Author: serge $

require_once 'add_random_ride.php';
require_once __DIR__.'/../helper_add_order.php';
require_once __DIR__.'/../helper_get_dash_screen_shopper.php';
require_once __DIR__.'/../helper_get_dash_screen_user.php';
require_once '../credentials_shoppers.php';

$ride_id = NULL;

add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );

$items = array();

array_push( $items, new \shopndrop_protocol\ShoppingItem( 121212, 1 ) );
array_push( $items, new \shopndrop_protocol\ShoppingItem( 232323, 2 ) );
array_push( $items, new \shopndrop_protocol\ShoppingItem( 343434, 7 ) );

$shopping_list  = new \shopndrop_protocol\ShoppingList( $items );

$delivery_address = new \shopndrop_protocol\Address( 50668, "Germany", "Köln", "Eigelstein", "10", "" );

$order_id = NULL;
$resp = NULL;

$res = \shopndrop_api\add_order_auto( $host, $port, $login_2, $password, $ride_id, $shopping_list, $delivery_address, $order_id, $resp );

$res = \shopndrop_api\get_dash_screen_shopper_auto( $host, $port, $login_1, $password, 50668, $resp );

if( $res )
{
    echo \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
}

$res = \shopndrop_api\get_dash_screen_user_auto( $host, $port, $login_2, $password, 50668, $resp );

if( $res )
{
    echo \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
}

?>
