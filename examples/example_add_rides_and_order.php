<?php
// $Revision: 13738 $ $Date:: 2020-09-07 #$ $Author: serge $

require_once 'add_random_ride.php';
require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_web_protocol/html_helper.php';
require_once __DIR__.'/../../basic_objects/object_initializer.php';
require_once '../credentials_shoppers.php';

try
{
    $api = new \shopndrop_api\Api( $host, $port );

    $session_id_1 = NULL;

    $api->open_session( $login_1, $password, $session_id_1, $error_msg );

    $user_id_1 = NULL;

    $api->get_user_id( $session_id_1, $login_1, $user_id_1, $error_msg );

    $session_id_2 = NULL;

    $api->open_session( $login_2, $password, $session_id_2, $error_msg );

    $user_id_2 = NULL;

    $api->get_user_id( $session_id_2, $login_2, $user_id_2, $error_msg );

    $ride_id = NULL;

    add_random_ride( $host, $port, $login_1, $password, 50668, 30, 2, $ride_id );

    $items = array();

    array_push( $items, \shopndrop_protocol\create__ShoppingItem( 13, 1 ) );
    array_push( $items, \shopndrop_protocol\create__ShoppingItem( 14, 2 ) );
    array_push( $items, \shopndrop_protocol\create__ShoppingItem( 15, 7 ) );

    $shopping_list  = \shopndrop_protocol\create__ShoppingList( $items );

    $delivery_address = \shopndrop_protocol\create__Address( 50668, "Germany", "Köln", "Eigelstein", "10", "" );

    $order_id = NULL;

    $resp = NULL;

    $api->add_order( $session_id_2, $ride_id, $shopping_list, $delivery_address, $order_id, $resp );

    $res = $api->get_dash_screen_shopper( $session_id_1, $user_id_1, 50668, $resp );

    if( $res )
    {
        echo \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
    }

    $res = $api->get_dash_screen_user( $session_id_2, $user_id_2, 50668, $resp );

    if( $res )
    {
        echo \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
    }

    $api->close_session( $session_id_1, $error_msg );
    $api->close_session( $session_id_2, $error_msg );
}
catch( \Exception $e )
{
    echo "FATAL: $e\n";
}

?>
