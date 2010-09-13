<?php
// $Autho: wishcraft $

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for compunds
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class SoupsCompounds_uid_link extends XoopsObject
{

    function SoupsCompounds_uid_link($id = null)
    {
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('score', XOBJ_DTYPE_FLOAT, 0, false);
		$this->initVar('submissions', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('donations', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('amount', XOBJ_DTYPE_DECIMAL, 0, false);
		$this->initVar('hits', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('runners', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('votes', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('stars', XOBJ_DTYPE_DECIMAL, 0, false);
		$this->initVar('comments', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('edits', XOBJ_DTYPE_INT, 0, false);
		
    }

}


/**
* XOOPS policies handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class SoupsCompounds_uid_linkHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "uid_link", 'SoupsCompounds_uid_link', "uid", "compounds");
    }
}

?>