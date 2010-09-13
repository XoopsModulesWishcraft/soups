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
class SoupsChain_compounds extends XoopsObject
{

	var $language = '';
	
    function SoupsChain_compounds($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('chain_id', XOBJ_DTYPE_INT, null, true);
		$this->initVar('compound_id', XOBJ_DTYPE_INT, null, true);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('weight', XOBJ_DTYPE_INT, null, false);	
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
class SoupsChain_compoundsHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "soups_chain_compounds", 'SoupsChain_compounds', "id", "compound_id");
    }
	
	function get($id = 0) {
		$languageHandler =& xoops_getmodulehandler('language', 'soups');
		if ($id<>0) {
			$obj = parent::get($id);
			$criteria = new CriteriaCompo(new Criteria('chain_compound_id', $id));
			$criteria->add(new Criteria('chain_id', $obj->getVar('chain_id'));
			$criteria->add(new Criteria('compound_id', $obj->getVar('compound_id'));
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
		$languageHandler =& xoops_getmodulehandler('language', 'soups');
		$objs = parent::getObjects($criteria, $id_as_key, $as_object);
		foreach($objs as $id => $obj) {
			$criteria = new CriteriaCompo(new Criteria('chain_compound_id', $obj->getVar('id')));
			$criteria->add(new Criteria('chain_id', $obj->getVar('chain_id'));
			$criteria->add(new Criteria('compound_id', $obj->getVar('compound_id'));
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
		$languageHandler =& xoops_getmodulehandler('language', 'soups');
		if ($id = parent::insert($obj, $force)) {
			$obj->language->setVar('chain_compound_id', $id);
			$obj->language->setVar('compound_id', $obj->getVar('compound_id'));
			$obj->language->setVar('chain_id', $obj->getVar('chain_id'));
			if ($languageHandler->insert($obj->language, $force, $setlanguage))
				return $id;
			else
				return false;
		} 
		return false;
	}
}

?>