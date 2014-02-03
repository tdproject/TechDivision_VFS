<?php

/**
 * License: GNU General Public License
 *
 * Copyright (c) 2009 TechDivision GmbH.  All rights reserved.
 * Note: Original work copyright to respective authors
 *
 * This file is part of TechDivision GmbH - Connect.
 *
 * faett.net is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * faett.net is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 * USA.
 *
 * @package TechDivision_VFS
 */

require_once 'TechDivision/StreamWrapper/APC.php';
require_once 'TechDivision/VFS/Stream.php';

/**
 * @package TechDivision_VFS
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_VFS_Stream_APC
    extends TechDivision_VFS_Stream {

    /**
     * The stream protocol to use.
     * @var string
     */
    const PROTOCOL = 'apc';

    /**
     * Initializes the stream wrapper and registers
     * it under the protocol 'apc'.
     *
     * @return void
     */
    public function __construct()
    {
        // check if stream has already been registered
        if (in_array($this->_getProtocol(), stream_get_wrappers())) {
            return;
        }
        // register the APC stream wrapper
        stream_wrapper_register(
        	$this->_getProtocol(),
        	'TechDivision_StreamWrapper_APC'
        );
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Stream::_getProtocol()
     */
    protected function _getProtocol()
    {
        return self::PROTOCOL;
    }
}