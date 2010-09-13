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
class SoupsPeriodical extends XoopsObject
{	

	var $language = '';

    function SoupsPeriodical($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('symbol', XOBJ_DTYPE_TXTBOX, null, true, 4);
        $this->initVar('weight', XOBJ_DTYPE_INT, null, true);
		$this->initVar('period', XOBJ_DTYPE_INT, null, true);
		$this->initVar('group', XOBJ_DTYPE_INT, null, true);
        $this->initVar('type', XOBJ_DTYPE_ENUM, null, true, false, false, array('base','lanthanoids','actinoids'));
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
class SoupsPeriodicalHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "periodical", 'SoupsPeriodical', "id", "symbol");
    }
	
	function get($id = 0) {
		$languageHandler =& xoops_getmodulehandler('compounds_language', 'soups');
		if ($id<>0) {
			$obj = parent::get($id);
			$criteria = new CriteriaCompo(new Criteria('periodic_id', $id));
			$langobjs = $languageHandler->getObjects($criteria, false);
			if (is_object($langobjs[0])) {
				$obj->language = $langobjs[0];
			} else {
				$obj->language = $languageHandler->create();
				$obj->language->setVar('created', time(), true);
				$obj->language->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'), true);
			}
		} else {
			$obj = parent::create();
			$obj->language = $languageHandler->create();		
		}
		return $obj;
	}

	function getObjects($criteria = NULL, $id_as_key = false, $as_object = true) {
		$languageHandler =& xoops_getmodulehandler('compounds_language', 'soups');
		$objs = parent::getObjects($criteria, $id_as_key, $as_object);
		foreach($objs as $id => $obj) {
			$criteria = new CriteriaCompo(new Criteria('periodic_id', $obj->getVar('id')));
			$langobjs = $languageHandler->getObjects($criteria, false);
			if (is_object($langobjs[0])) {
				$objs[$id]->language = $langobjs[0];
			} else {
				$objs[$id]->language = $languageHandler->create();
				$objs[$id]->language->setVar('created', time());
				if (is_object($GLOBALS['xoopsUser']))
					$objs[$id]->language->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
				else
					$objs[$id]->language->setVar('uid', 0);
			}
		} 
		return $objs;
	}
	
	function insert($obj, $force = true, $setlanguage) {
		$languageHandler =& xoops_getmodulehandler('compounds_language', 'soups');
		if ($id = parent::insert($obj, $force)) {
			$obj->language->setVar('periodic_id', $id, true);
			$obj->language->setVar('symbol', $obj->getVar('symbol'), true);
			if ($languageHandler->insert($obj->language, $force, $setlanguage))
				return $id;
			else
				return false;
		} 
		return false;
	}
}

?>