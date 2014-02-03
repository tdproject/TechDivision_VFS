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

require_once 'TechDivision/Lang/Exceptions/ClassCastException.php';
require_once 'TechDivision/Collections/AbstractCollection.php';

/**
 * @package TechDivision_VFS_Collections
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_VFS_Collections_Filesystem
    extends TechDivision_Collections_AbstractCollection {

    /**
     * This method adds the passed filesystem to the HashMap.
     *
     * @param TechDivision_VFS_Interfaces_Filesystem $fs
     * 		The filesystem to add
     * @return void
     */
    public function add(TechDivision_VFS_Interfaces_Filesystem $fs) {
        // add the item as first element of the array
        array_unshift($this->_items, $fs);
    }

    /**
     * Unregisters the filesystems and empty the
     * Collection.
     *
     * @return void
     * @see TechDivision_Collections_AbstractCollection::clear()
     */
    public function clear()
    {
        // unregisters all filesystem before removing them
        for ($i = 0; $i < $this->size(); $i++) {
            if ($this->_items[$i]->unregister() === false) {

            }
        }
        // clear the Collection
        parent::clear();
    }
}