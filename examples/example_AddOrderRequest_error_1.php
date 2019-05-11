<?php
// $Revision: 11258 $ $Date:: 2019-05-11 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_protocol/html_helper_web.php';
require_once '../credentials.php';

$error_msg = "";

$user_id = 0;

$ride_id = 0;
$order_id = 0;

echo "\n";
echo "TEST: AddOrderRequest\n";
{
    $api = new \shopndrop_api\Api( $host, $port );

    $session_id = NULL;

    // open session
    if( $api->open_session( $login, $password, $session_id, $error_msg ) == true )
    {
        echo "OK: opened session\n";

        // get user ID
        $req = new \generic_protocol\GetUserIdRequest( $session_id, $login );

        echo "REQ = " . $req->to_generic_request() . "\n";
        $resp = $api->submit( $req );
        echo "user id = " . $resp->user_id . "\n\n";
        $user_id = $resp->user_id;

        // create order

        $items = array();

        array_push( $items, new \shopndrop_protocol\ShoppingItem( 121212, 1 ) );
        array_push( $items, new \shopndrop_protocol\ShoppingItem( 232323, 2 ) );
        array_push( $items, new \shopndrop_protocol\ShoppingItem( 343434, 7 ) );

        $shopping_list  = new \shopndrop_protocol\ShoppingList( $items );

        $delivery_address = new \shopndrop_protocol\Address( 50668, "Germany", "Köln", "Eigelstein", "10", "" );

        $req = new \shopndrop_protocol\AddOrderRequest( $session_id, $ride_id, $shopping_list, $delivery_address );

        // execute request
        {
            $req = new \shopndrop_protocol\AddOrderRequest( $session_id, $ride_id, $shopping_list, $delivery_address );

            echo "REQ = " . $req->to_generic_request() . "\n";
            $resp = $api->submit( $req );

            if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
            {
                echo "ERROR: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
            }
            elseif( get_class( $resp ) == "shopndrop_protocol\AddOrderResponse" )
            {
                $order_id = $resp->order_id;
                echo "OK: " . \shopndrop_protocol\web\to_html( $resp ) . "\n\n";
            }
            else
            {
                echo "ERROR: unknown response: " . get_class( $resp ) . "\n\n";
            }
        }

        // close session
        if( $api->close_session( $session_id, $error_msg ) == true )
        {
            echo "OK: session closed\n";
        }
        else
        {
            echo "ERROR: cannot close session: $error_msg\n";
        }
    }
    else
    {
        echo "ERROR: cannot open session: $error_msg\n";
    }
}

?>