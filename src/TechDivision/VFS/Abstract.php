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
require_once 'TechDivision/VFS/Interfaces/ClassLoader.php';
require_once 'TechDivision/VFS/Interfaces/Filesystem.php';

/**
 * @package TechDivision_VFS
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
abstract class TechDivision_VFS_Abstract
    extends TechDivision_Lang_Object
    implements TechDivision_VFS_Interfaces_Filesystem {

    /**
     * The class loader instance.
     * @var TechDivision_VFS_Interfaces_ClassLoader
     */
    protected $_cl = null;

    /**
     * Array for storing already virtualized classes.
     * @var array
     */
    protected $_files = array();

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Interfaces_Filesystem::unregister()
     */
    public function unregister()
    {
       return true;
    }

    /**
     * Render the filesystem class name for logging purposes.
     *
     * @return string The filesystem's class name
     */
    public function __toString()
    {
        return get_class($this);
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Interfaces_Filesystem::hasSpace()
     */
    public function hasSpace()
    {
        return true;
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Interfaces_Filesystem::exists($file)
     */
    public function exists(TechDivision_VFS_Interfaces_File $file)
    {
        return array_key_exists($file->getFilename(), $this->_files);
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Interfaces_Filesystem::initialize()
     */
    public function initialize(
        TechDivision_VFS_Interfaces_ClassLoader $cl) {
        $this->_cl = $cl;
        return $this;
    }
}