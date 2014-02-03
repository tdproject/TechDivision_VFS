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

require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/VFS/Interfaces/File.php';
require_once 'TechDivision/VFS/Interfaces/Virtualizer.php';

/**
 * @package TechDivision_VFS
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_VFS_File
    extends TechDivision_Lang_Object
    implements TechDivision_VFS_Interfaces_File {

    protected $_filename = null;

    protected $_virtualizer = null;

    public function __construct($filename)
    {
        $this->_filename = new TechDivision_Lang_String($filename);
    }

    public function getFilename()
    {
        return $this->_filename->__toString();
    }

    public function setVirtualizer(
        TechDivision_VFS_Interfaces_Virtualizer $virtualizer) {
        $this->_virtualizer = $virtualizer;
    }

    /**
     * Returns the virtualized content.
     *
     * @return string The virtualized content
     */
    public function virtualize()
    {
        if (!empty($this->_virtualizer)) {
            return $this->_virtualizer->virtualize(
                $this->_filename
            );
        }

        return  $this->_filename->__toString();
    }

    public function __toString()
    {
        return $this->_filename->__toString();
    }
}