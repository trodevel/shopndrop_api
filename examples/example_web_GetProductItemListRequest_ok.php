<?php
// $Revision: 13684 $ $Date:: 2020-09-04 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_web_protocol/html_helper.php';
require_once '../credentials.php';

$error_msg = "";

$user_id = 0;

echo "\n";
echo "TEST: GetProductItemListRequest\n";
try
{
    $api = new \shopndrop_api\Api( $host, $port );

    $session_id = NULL;

    $api->open_session( $login, $password, $session_id, $error_msg );

    $api->get_user_id( $session_id, $login, $user_id, $error_msg );

    echo "user id = " . $user_id . "\n\n";

    $resp = NULL;

    $api->get_product_item_list( $session_id, $resp );

    echo \shopndrop_web_protocol\to_html( $resp ) . "\n\n";

    $api->close_session( $session_id, $error_msg );
}
catch( \Exception $e )
{
    echo "FATAL: $e\n";
}

?>
