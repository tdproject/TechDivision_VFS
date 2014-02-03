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

require_once 'TechDivision/VFS/Abstract.php';
require_once 'TechDivision/VFS/Interfaces/File.php';

/**
 * @package TechDivision_VFS
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
abstract class TechDivision_VFS_Stream
    extends TechDivision_VFS_Abstract {

    /**
     * Returns the protocol used by the stream.
     *
     * @return string The protocol
     */
    protected abstract function _getProtocol();

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Interfaces_Filesystem::get($file)
     */
    public function get(TechDivision_VFS_Interfaces_File $file)
    {
        return $this->_files[$file->getFilename()];
    }

    /**
     * Unregisters the stream wrapper.
     *
     * @return boolean TRUE if the unregistered successfully, else FALSE
     */
    public function unregister()
    {
        return stream_wrapper_unregister($this->_getProtocol());
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision_VFS_Interfaces_Filesystem::virtualize()
     */
    public function virtualize(TechDivision_VFS_Interfaces_File $file)
    {
        // load the file content to virtualize
        $source = file_get_contents($filename = $file->getFilename(), true);
        // create the URL use to store the virtualized content
        $url = $this->_getProtocol() . '://' . $file->virtualize();
        // store the virtualized content under the URL
        if (file_put_contents($url, $source) === false) {
            throw new Exception('Error when virtualizing ' . $url);
        }
        // register the virtualized file and return the URL
        return $this->_files[$filename] = $url;
    }
}