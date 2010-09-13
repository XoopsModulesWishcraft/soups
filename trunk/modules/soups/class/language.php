<?php
// $Autho: wishcraft $

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for compounds
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class SoupsLanguage extends XoopsObject
{

    function SoupsLanguage($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('language', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('soup_id', XOBJ_DTYPE_INT, null, false);		
        $this->initVar('chain_id', XOBJ_DTYPE_INT, null, false);		
        $this->initVar('compound_id', XOBJ_DTYPE_INT, null, false);	
        $this->initVar('chain_compound_id', XOBJ_DTYPE_INT, null, false);			
		$this->initVar('symbol', XOBJ_DTYPE_TXTBOX, null, false, 4);	
		$this->initVar('alias', XOBJ_DTYPE_TXTBOX, null, false, 255);		
		$this->initVar('hyposise', XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('process', XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('synopsise', XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, true);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
    }

}


/**
* XOOPS compounds handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class SoupsLanguageHandler extends XoopsPersistableObjectHandler
{							
 
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "soups_language", 'SoupsLanguage', "id", "chain_id");
    }
	
}

?>