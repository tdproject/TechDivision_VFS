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
require_once 'TechDivision/VFS/ClassLoader.php';
require_once 'TechDivision/VFS/Stream/Temporary.php';
require_once 'TechDivision/VFS/Stream/APC.php';

/**
 * This is the test for the class loader.
 *
 * @package TechDivision_VFS
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_VFS_ClassLoaderTest extends PHPUnit_Framework_TestCase {

    /**
     * VFS class loader instance to test.
     * @var TechDivision_VFS_ClassLoader
     */
    private $_vfs = null;

    public function setUp()
    {
        // initialize a new VFS class loader instance
        $this->_vfs = TechDivision_VFS_ClassLoader::register();
    }

	/**
	 * This test checks the resolved class name.
	 *
	 * @return void
	 */
	function testFilesystemAPC()
	{
        $this->_vfs->registerFilesystem(new TechDivision_VFS_Stream_APC());
        // create a new instance
        $test = new TechDivision_VFS_TestClass($name = 'Foo');
        // check that the class works
        $this->assertEquals($name, $test->getName());
	}

	/**
	 * This test checks the resolved class name.
	 *
	 * @return void
	 */
	function testFilesystemTemporary()
	{
	    $this->_vfs->resetFilesystem();
        $this->_vfs->registerFilesystem(new TechDivision_VFS_Stream_Temporary());
        // create a new instance
        $test = new TechDivision_VFS_TestClass($name = 'Foo');
        // check that the class works
        $this->assertEquals($name, $test->getName());
	}

	/**
	 * This test checks the resolved class name.
	 *
	 * @return void
	 */
	function testWithoutFilesystem()
	{
	    $this->_vfs->resetFilesystem();
        // create a new instance
        $test = new TechDivision_VFS_TestClass($name = 'Foo');
        // check that the class works
        $this->assertEquals($name, $test->getName());
	}

	/**
	 * This test checks the resolved class name.
	 *
	 * @return void
	 */
	function testAllFilesystems()
	{
	    $this->_vfs->resetFilesystem();
        $this->_vfs->registerFilesystem(new TechDivision_VFS_Stream_Temporary());
        $this->_vfs->registerFilesystem(new TechDivision_VFS_Stream_APC());
        // create a new instance
        $test = new TechDivision_VFS_TestClass($name = 'Foo');
        // check that the class works
        $this->assertEquals($name, $test->getName());
	}
}