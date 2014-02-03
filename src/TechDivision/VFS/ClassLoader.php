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
require_once 'TechDivision/VFS/Collections/Filesystem.php';
require_once 'TechDivision/VFS/File.php';
require_once 'TechDivision/VFS/OS.php';
require_once 'TechDivision/VFS/Interfaces/File.php';
require_once 'TechDivision/VFS/Interfaces/Filesystem.php';

/**
 * @package TechDivision_VFS
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_VFS_ClassLoader
    extends TechDivision_Lang_Object
    implements TechDivision_VFS_Interfaces_ClassLoader {

	/**
	 * The singleton instance.
	 * @var TechDivision_VFS_ClassLoader
	 */
    protected static $_instance = null;

    /**
     * Collection with the available filesystems.
     * @var TechDivision_VFS_Collections_Filesystem
     */
    protected $_vfs = null;

    /**
     * Initialize the class loader.
     * 
     * @return void
     */
    protected function __construct()
    {
        $this->_vfs = new TechDivision_VFS_Collections_Filesystem();
        $this->resetFilesystem();
    }

    /**
     * Returns the class loader instance as singleton.
     * 
     * @return TechDivision_VFS_ClassLoader
     * 		The class loader instance as singleton
     */
    public static function get()
    {
        if (self::$_instance == null) {
            self::$_instance = new TechDivision_VFS_ClassLoader();
        }
        return self::$_instance;
    }

    /**
     * Registers the class loader for system autoloading functionality.
     * 
     * @return TechDivision_VFS_ClassLoader The instance itself
     */
    public static function register()
    {
        spl_autoload_register(array($instance = self::get(), 'autoload'));
        return $instance;
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Interfaces_ClassLoader::registerFilesystem()
     */
    public function registerFilesystem(
        TechDivision_VFS_Interfaces_Filesystem $fs) {
        $this->_vfs->add($fs->initialize($this));
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Interfaces_ClassLoader::resetFilesystem()
     */
    public function resetFilesystem()
    {
        $this->_vfs->clear();
        $this->registerFilesystem(new TechDivision_VFS_OS());
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Interfaces_ClassLoader::autoload()
     */
    public function autoload($class)
    {
        // if the class file contains a backslash, it must be treated
        // as name-spaced, so do not use _ but \ as separator.
        if(strpos($class, '\\') !== false) {
            $separator = '\\';
        } else {
            // if the class is not namespaced, use _ as the separator
            $separator = '_';
        }

		// prepare the class name by replacing _ and remove camelcase
        $prepared = ucwords(str_replace($separator, ' ', $class));
		// replace the empty spaces with the system directory separator
        $classFile = str_replace(' ', DIRECTORY_SEPARATOR, $prepared);
		// append the PHP suffix
        $classFile .= '.php';
		// load the class from the virtual file system
        $this->import($classFile);
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Interfaces_ClassLoader::import()
     */
    public function import($filename)
    {
        // create the virtual file
        $file = new TechDivision_VFS_File($filename);
        // check if the has already been imported
        foreach($this->_vfs as $vfs) {
            if ($vfs->exists($file)) {
                // include the file and return
                return require_once $vfs->get($file);
            }
        }
        // if not, attach the file to the filesystem, include it and return
        return require_once $this->_attach($file);
    }

    /**
     * Attaches the file to the virtual file system.
     * 
     * @param TechDivision_VFS_Interfaces_File $file The file to attach
     * @return The filename of the attached file
     */
    protected function _attach(TechDivision_VFS_Interfaces_File $file)
    {
        foreach ($this->_vfs as $vfs) {
            if ($vfs->hasSpace()) {
                return $vfs->virtualize($file);
            }
        }
    }
}