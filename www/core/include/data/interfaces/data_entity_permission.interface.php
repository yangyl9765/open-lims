<?php
/**
 * @package data
 * @version 0.4.0.0
 * @author Roman Konertz
 * @copyright (c) 2008-2011 by Roman Konertz
 * @license GPLv3
 * 
 * This file is part of Open-LIMS
 * Available at http://www.open-lims.org
 * 
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * version 3 of the License.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, see <http://www.gnu.org/licenses/>.
 */


/**
 * Data Entity Interface
 * @package data
 */
interface DataEntityPermissionInterface
{	
	/**
	 * @param integer $permission
	 * @param bool $automatic
	 * @param integer $owner_id
	 * @param integer $owner_group_id
	 */
	function __construct($permission, $automatic, $owner_id, $owner_group_id);
	
	function __destruct();
	
	/**
	 * @param integer $folder_flag
	 * @return bool
	 */
	public function set_folder_flag($folder_flag);
	
	/**
	 * @param integer $intention
	 * @return bool
	 */	
	public function is_access($intention);
	
	/**
	 * @return string
	 */	
	public function get_permission_string();
}

?>
