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

require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/VFS/Interfaces/ClassLoader.php';
require_once 'TechDivision/VFS/Interfaces/File.php';

/**
 * @package TechDivision_VFS
 * @subpackage Interfaces
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
interface TechDivision_VFS_Interfaces_Filesystem
{

    public function hasSpace();

    public function unregister();

    public function initialize(TechDivision_VFS_Interfaces_ClassLoader $cl);

    public function exists(TechDivision_VFS_Interfaces_File $file);

    public function get(TechDivision_VFS_Interfaces_File $file);

    public function virtualize(TechDivision_VFS_Interfaces_File $file);
}