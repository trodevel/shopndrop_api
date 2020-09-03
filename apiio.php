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

// $Revision: 13646 $ $Date:: 2020-09-04 #$ $Author: serge $

namespace shopndrop_api;

require_once __DIR__.'/../shopndrop_protocol/protocol.php';
require_once __DIR__.'/../shopndrop_web_protocol/protocol.php';
require_once __DIR__.'/../shopndrop_protocol/parser.php';      // Parser::parse()
require_once __DIR__.'/../shopndrop_web_protocol/parser.php';  // Parser::parse()
require_once __DIR__.'/../generic_api/apiio.php';

class ApiIO extends \generic_api\ApiIO
{
    protected function parse_response( $resp )
    {
        $res = \shopndrop_web_protocol\Parser::parse( $resp );

        return $res;
    }

    protected function to_generic_request( $req )
    {
        $res = \shopndrop_web_protocol\to_generic_request( $req );

        return $res;
    }
}

?>
