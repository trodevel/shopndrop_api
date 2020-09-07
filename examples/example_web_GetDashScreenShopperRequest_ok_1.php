<?php
// $Revision: 13742 $ $Date:: 2020-09-07 #$ $Author: serge $

require_once __DIR__.'/../api.php';
require_once __DIR__.'/../../shopndrop_web_protocol/html_helper.php';
require_once __DIR__.'/../../basic_objects/object_initializer.php';
require_once '../credentials.php';

$error_msg = "";

echo "\n";
echo "TEST: GetDashScreenShopperRequest\n";
try
{
    $api = new \shopndrop_api\Api( $host, $port );

    $session_id = NULL;

    $api->open_session( $login, $password, $session_id, $error_msg );

    $user_id = NULL;

    $api->get_user_id( $session_id, $login, $user_id, $error_msg );

    $plz = 50668;

    $resp = NULL;

    $res = $api->get_dash_screen_shopper( $session_id, $user_id, $plz, $resp );

    if( $res == false )
    {
        echo "ERROR: " . \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
    }
    else
    {
        echo "OK: " . \shopndrop_web_protocol\to_html( $resp ) . "\n\n";
    }

    $api->close_session( $session_id, $error_msg );
}
catch( \Exception $e )
{
    echo "FATAL: $e\n";
}

?>
