<?php

/*

Shop'n'Drop API.

Copyright (C) 2019 Sergey Kolevatov

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

*/

// $Revision: 13672 $ $Date:: 2020-09-04 #$ $Author: serge $

namespace shopndrop_api;

require_once __DIR__.'/../generic_api/api.php';
require_once __DIR__.'/../shopndrop_protocol/object_initializer.php';
require_once __DIR__.'/../shopndrop_web_protocol/object_initializer.php';
require_once __DIR__.'/apiio.php';

class Api extends \generic_api\Api
{
    public function __construct( $host, $port )
    {
        parent::__construct( $host, $port );

        $this->apiio = new ApiIO( $host, $port );
    }

    public function accept_order( $session_id, $order_id, & $resp )
    {
        // execute request

        $req = \shopndrop_protocol\create__AcceptOrderRequest( $session_id, $order_id );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_protocol\AcceptOrderResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function add_order( $session_id, $ride_id, $shopping_list, $delivery_address, & $order_id, & $resp )
    {
        // execute request

        $req = \shopndrop_protocol\create__AddOrderRequest( $session_id, $ride_id, $shopping_list, $delivery_address );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_protocol\AddOrderResponse" )
        {
            $order_id = $resp->order_id;
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function time_to_LocalTime( $time )
    {
        $localtime  = localtime( $time, true );
        $res        = \basic_objects\create__LocalTime(
                $localtime["tm_year"] + 1900,
                $localtime["tm_mon"] + 1,
                $localtime["tm_mday"],
                $localtime["tm_hour"],
                $localtime["tm_min"],
                $localtime["tm_sec"] );

        return $res;
    }

    public function add_ride( $session_id, $plz, $delivery_time, $max_weight, & $ride_id, & $resp )
    {
        $position       = \shopndrop_protocol\create__GeoPosition( $plz, 0, 0 );

        $ride_summary   = \shopndrop_protocol\create__RideSummary( $position, $delivery_time, $max_weight );

        // execute request

        $req = \shopndrop_protocol\create__AddRideRequest( $session_id, $ride_summary );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_protocol\AddRideResponse" )
        {
            $ride_id = $resp->ride_id;
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function cancel_order( $session_id, $order_id, & $resp )
    {
        // execute request

        $req = \shopndrop_protocol\create__CancelOrderRequest( $session_id, $order_id );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_protocol\CancelOrderResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function cancel_ride( $session_id, $ride_id, & $resp )
    {
        // execute request

        $req = \shopndrop_protocol\create__CancelRideRequest( $session_id, $ride_id );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_protocol\CancelRideResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function decline_order( $session_id, $order_id, & $resp )
    {
        // execute request

        $req = \shopndrop_protocol\create__DeclineOrderRequest( $session_id, $order_id );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_protocol\DeclineOrderResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function get_dash_screen_shopper( $session_id, $user_id, $plz, & $resp )
    {
        // execute request

        $position = \shopndrop_protocol\create__GeoPosition( $plz, 0, 0 );

        $req = \shopndrop_web_protocol\create__GetDashScreenshopperRequest( $session_id, $user_id, $position );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_web_protocol\GetDashScreenShopperResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function get_dash_screen_user( $session_id, $user_id, $plz, & $resp )
    {
        // execute request

        $position = \shopndrop_protocol\create__GeoPosition( $plz, 0, 0 );

        $req = \shopndrop_web_protocol\create__GetDashScreenUserRequest( $session_id, $user_id, $position );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_web_protocol\GetDashScreenUserResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function get_product_item_list( $session_id, & $resp )
    {
        // execute request

        $req = \shopndrop_web_protocol\create__GetProductItemListRequest( $session_id );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_web_protocol\GetProductItemListResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function get_ride( $session_id, $ride_id, & $resp )
    {
        // execute request

        $req = \shopndrop_protocol\create__GetRideRequest( $session_id, $ride_id );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_protocol\GetRideResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function get_shopping_list_with_totals( $session_id, $shopping_list_id, & $resp )
    {
        // execute request

        $req = \shopndrop_web_protocol\create__GetShoppingListWithTotalsRequest( $session_id, $shopping_list_id );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_web_protocol\GetShoppingListWithTotalsResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function get_shopping_request_info( $session_id, $ride_id, & $resp )
    {
        // execute request

        $req = \shopndrop_web_protocol\create__GetShoppingRequestInfoRequest( $session_id, $ride_id );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_web_protocol\GetShoppingRequestInfoResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function mark_delivered_order( $session_id, $order_id, & $resp )
    {
        // execute request

        $req = \shopndrop_protocol\create__MarkDeliveredOrderRequest( $session_id, $order_id );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_protocol\MarkDeliveredOrderResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    public function rate_shopper( $session_id, $order_id, $stars, & $resp )
    {
        // execute request

        $req = \shopndrop_protocol\create__RateShopperRequest( $session_id, $order_id, $stars );

        $resp = $this->apiio->submit( $req );

        if( get_class ( $resp ) == "generic_protocol\ErrorResponse" )
        {
            return false;
        }
        elseif( get_class( $resp ) == "shopndrop_protocol\RateShopperResponse" )
        {
            return true;
        }

        throw new InternalException( "unexpected response: " . get_class( $resp ) );
    }

    private $apiio;  // ApiIO
}

?>
