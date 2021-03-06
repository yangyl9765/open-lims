<?php
/**
 * @package project
 * @version 0.4.0.0
 * @author Roman Konertz <konertz@open-lims.org>
 * @copyright (c) 2008-2016 by Roman Konertz
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
 * Project Status Access Class
 * @package project
 */
class ProjectStatus_Access
{
	const PROJECT_STATUS_PK_SEQUENCE = 'core_project_status_id_seq';

	private $project_status_id;

	private $name;
	private $analysis;
	private $blocked;
	private $comment;
	
	/**
	 * @param integer $project_status_id
	 */
	function __construct($project_status_id)
	{
		global $db;

		if ($project_status_id == null)
		{
			$this->project_status_id = null;
		}
		else
		{
			$sql = "SELECT * FROM ".constant("PROJECT_STATUS_TABLE")." WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $project_status_id, PDO::PARAM_INT);
			$db->execute($res);		
			$data = $db->fetch($res);
			
			if ($data['id'])
			{
				$this->project_status_id	= $project_status_id;
				
				$this->name					= $data['name'];
				$this->comment				= $data['comment'];
				$this->analysis				= $data['analysis'];
				$this->blocked				= $data['blocked'];
			}
			else
			{
				$this->project_status_id = null;
			}
		}
	}
	
	function __destruct()
	{
		if ($this->project_status_id)
		{
			unset($this->project_status_id);
						
			unset($this->name);
			unset($this->analysis);
			unset($this->blocked);
			unset($this->comment);
		}
	}
	
	/**
	 * @param string $name
	 * @return integer
	 */
	public function create($name, $comment)
	{
		global $db;
		
		if ($name)
		{
			$sql_write = "INSERT INTO ".constant("PROJECT_STATUS_TABLE")." " .
							"(id,name,analysis,blocked,comment) " .
							"VALUES (nextval('".self::PROJECT_STATUS_PK_SEQUENCE."'::regclass), :name, 'f', 'f', :comment)";
			
			$res_write = $db->prepare($sql_write);
			$db->bind_value($res_write, ":name", $name, PDO::PARAM_STR);
			
			if (isset($comment))
			{
				$db->bind_value($res_write, ":comment", $comment, PDO::PARAM_STR);
			}
			else
			{
				$db->bind_value($res_write, ":comment", null, PDO::PARAM_NULL);
			}
			
			if ($db->row_count($res_write) == 1)
			{
				$sql_read = "SELECT id FROM ".constant("PROJECT_STATUS_TABLE")." WHERE id = currval('".self::PROJECT_STATUS_PK_SEQUENCE."'::regclass)";
				$res_read = $db->prepare($sql_read);
				$db->execute($res_read);
				$data_read = $db->fetch($res_read);
								
				self::__construct($data_read['id']);				
								
				return $data_read['id'];
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * @return bool
	 */
	public function delete()
	{
    	global $db;
    	
    	if ($this->project_status_id)
    	{
    		$tmp_project_status_id = $this->project_status_id;
    		
    		$this->__destruct();
    		
    		$sql = "DELETE FROM ".constant("PROJECT_STATUS_TABLE")." WHERE id = :id";
    		$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $tmp_project_status_id, PDO::PARAM_INT);
			$db->execute($res);
    		
    		if ($db->row_count($res) == 1)
    		{
    			return true;
    		}
    		else
    		{
    			return false;
    		}
    	}
    	else
    	{
    		return false;
    	}
    }
	
	/**
	 * @return string
	 */
	public function get_name()
	{
    	if ($this->name)
    	{
			return $this->name;
		}
		else
		{
			return null;
		}
    }
    
    /**
     * @return bool
     */
    public function get_analysis()
    {
    	if (isset($this->analysis))
    	{
			return $this->analysis;
		}
		else
		{
			return null;
		}
    }
    
    /**
     * @return bool
     */
    public function get_blocked()
    {
    	if (isset($this->blocked))
    	{
			return $this->blocked;
		}
		else
		{
			return null;
		}
    }
    
    /**
     * @return string
     */
    public function get_comment()
    {
    	if ($this->comment)
    	{
			return $this->comment;
		}
		else
		{
			return null;
		}
    }
    
    /**
     * @param string $name
     * @return bool
     */
    public function set_name($name)
    {		
		global $db;

		if ($this->project_status_id and $name)
		{
			$sql = "UPDATE ".constant("PROJECT_STATUS_TABLE")." SET name = :name WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->project_status_id, PDO::PARAM_INT);
			$db->bind_value($res, ":name", $name, PDO::PARAM_STR);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->name = $name;
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @param bool $analysis
	 * @return bool
	 */
	public function set_analysis($analysis)
	{
		global $db;
		
		if ($this->project_status_id and isset($analysis))
		{			
			$sql = "UPDATE ".constant("PROJECT_STATUS_TABLE")." SET analysis = :analysis WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->project_status_id, PDO::PARAM_INT);
			$db->bind_value($res, ":analysis", $analysis, PDO::PARAM_BOOL);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->analysis = $analysis;
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @param bool $blocked
	 * @return bool
	 */
	public function set_blocked($blocked)
	{
		global $db;

		if ($this->project_status_id and isset($blocked))
		{			
			$sql = "UPDATE ".constant("PROJECT_STATUS_TABLE")." SET blocked = :blocked WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->project_status_id, PDO::PARAM_INT);
			$db->bind_value($res, ":blocked", $blocked, PDO::PARAM_BOOL);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->blocked = $blocked;
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @param string $comment
	 * @return bool
	 */
	public function set_comment($comment)
	{
		global $db;

		if ($this->project_status_id and $comment)
		{
			$sql = "UPDATE ".constant("PROJECT_STATUS_TABLE")." SET comment = :comment WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->project_status_id, PDO::PARAM_INT);
			$db->bind_value($res, ":comment", $comment, PDO::PARAM_STR);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->comment = $comment;
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	
	/**
	 * @param integer $id
	 * @return bool
	 */
	public static function exist_id($id)
	{
		global $db;

		if (is_numeric($id))
		{
			$sql = "SELECT id FROM ".constant("PROJECT_STATUS_TABLE")." WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $id, PDO::PARAM_INT);
			$db->execute($res);
			$data = $db->fetch($res);
			
			if ($data['id'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
		
}
?>
