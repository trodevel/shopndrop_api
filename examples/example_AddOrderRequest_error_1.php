<?php
// $Revision: 13722 $ $Date:: 2020-09-06 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_web_protocol/html_helper.php';
require_once '../credentials.php';

$error_msg = "";

$user_id = 0;

$ride_id = 0;
$order_id = 0;

echo "\n";
echo "TEST: AddOrderRequest\n";
try
{
    $api = new \shopndrop_api\Api( $host, $port );

    $session_id = NULL;

    $api->open_session( $login, $password, $session_id, $error_msg );

    $api->get_user_id( $session_id, $login, $user_id, $error_msg );

    echo "user id = " . $user_id . "\n\n";

    // create order

    $items = array();

    array_push( $items, \shopndrop_protocol\create__ShoppingItem( 121212, 1 ) );
    array_push( $items, \shopndrop_protocol\create__ShoppingItem( 232323, 2 ) );
    array_push( $items, \shopndrop_protocol\create__ShoppingItem( 343434, 7 ) );

    $shopping_list  = \shopndrop_protocol\create__ShoppingList( $items );

    $delivery_address = \shopndrop_protocol\create__Address( 50668, "Germany", "Köln", "Eigelstein", "10", "" );

    // execute request

    $resp = NULL;

    $api->add_order( $session_id, $ride_id, $shopping_list, $delivery_address, $order_id, $resp );

    echo \shopndrop_web_protocol\to_html( $resp ) . "\n\n";

    $api->close_session( $session_id, $error_msg );
}
catch( \Exception $e )
{
    echo "FATAL: $e\n";
}

?>
