<?php
/**
 * @package sample
 * @version 0.4.0.0
 * @author Roman Konertz
 * @copyright (c) 2008-2010 by Roman Konertz
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
 * Registering Functions
 */ 
function register_sample($include_id)
{	
	if (Item::delete_type_by_include_id($include_id))
	{
		if (Item::register_type("sample", "Sample", $include_id) == false)
		{
			return false;
		}
	}
	else
	{
		return false;
	}
	
	if (Folder::delete_type_by_include_id($include_id))
	{
		if (Folder::register_type("sample_folder", "SampleFolder", $include_id) == false)
		{
			return false;
		}		
	}
	else
	{
		return false;
	}
	return true;
}
$result = register_sample($key);
?>