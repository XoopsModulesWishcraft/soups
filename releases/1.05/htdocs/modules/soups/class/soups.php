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
class SoupsSoups extends XoopsObject
{

    function SoupsSoups($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('chain_id', XOBJ_DTYPE_INT, null, true);		
		$this->initVar('uid', XOBJ_DTYPE_INT, null, true);
		$this->initVar('created', XOBJ_DTYPE_INT, null, true);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, true);
		$this->initVar('chem_tags', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('comments', XOBJ_DTYPE_INT, null, false);
		$this->initVar('votes', XOBJ_DTYPE_INT, null, false);
		$this->initVar('stars', XOBJ_DTYPE_DECIMAL, null, false);
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
class SoupsSoupsHandler extends XoopsPersistableObjectHandler
{							
 
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "soups", 'SoupsSoups', "id", "name");
    }
	
	function getSymbolisation($ret_SoupsForm)
	{
		$periodicalHandler =& xoops_getmodulehandler('periodical', 'soups');
		$periodics =& $periodicalHandler->getObjects(NULL, true);
		extract($ret_SoupsForm);
		foreach ( $periodical as $yy => $value ) {
			if ($number[$yy]!=0||$periodical[$yy]!=0||$composition[$yy][1]!=0||$composition[$yy][2]!=0)
			{
				if ($number[$yy]!=0)
					$ret .= '%'.$number[$yy];
				if ($periodical[$yy]!=0)
					$ret .= '^'.$periodics[$periodical[$yy]]->getVar('symbol');
				if ($composition[$yy][1]!=0)
					$ret .= '#'.$composition[$yy][1];										
				if ($composition[$yy][2]!=0)
					$ret .= '*'.$composition[$yy][2];										

			}
		}
		return $ret;
	}

	function renderSymbolisation($symbolisism, $composition = NULL, $numberof = NULL)
    {
						
		if (!empty($composition)&&is_array($composition))
			$this->_composition = $composition;
		else {
			$compositionHandler =& xoops_getmodulehandler('composite', 'soups');
			$compositions = $compositionHandler->getObjects(NULL, true);
			if (is_array($compositions)) {
				$this->_composition = array(0=>'---');
				foreach ($compositions as $id => $object)
					$this->_composition[$id] = $object->getVar('symbol');
			}
			
		}
		
		if (!empty($numberof)&&is_array($numberof))
			$this->_numberof = $numberof;
		else {
			$compositionHandler =& xoops_getmodulehandler('numberof', 'soups');
			$numberofs = $compositionHandler->getObjects(NULL, true);
			if (is_array($numberofs)) {
				$this->_numberof = array(0=>'---');
				foreach ($numberofs as $id => $object)
					$this->_numberof[$id] = $object->getVar('symbol');
			}
		}
					
		$nof = intval(substr($symbolisism, strpos($symbolisism, '%')+1, strpos($symbolisism, '^')));
		if ($nof>31)
			$symbolisism = str_replace('%'.$nof, '%'.$this->_numberof[$nof], $symbolisism);
		# Number of Chains
    	$symbolisism = str_replace('%', '<font style="font-style:oblique;">', $symbolisism);

		#Normal Character - Periodical
		if (strpos($symbolisism, '<font '))
			$symbolisism = str_replace('^', '</font><font style="font-style:normal;">', $symbolisism);
		else
			$symbolisism = str_replace('^', '</sub><font style="font-style:normal;">', $symbolisism);
			
		#Superscript Character
		if (strpos($symbolisism, '<font '))			
			$symbolisism = str_replace('#', '</font><sup>', $symbolisism);		
		else
			$symbolisism = str_replace('#', '<sup>', $symbolisism);	
			
		## Subscript Character
		if (strpos($symbolisism, '<sup'))							
			$symbolisism = str_replace('*', '</sup><sub>', $symbolisism);		    
		elseif (strpos($symbolisism, '<font '))							
			$symbolisism = str_replace('*', '</font><sub>', $symbolisism);		    
		else
			$symbolisism = str_replace('*', '<sub>', $symbolisism);	

		## End of Font tag Character			
		if (strpos($symbolisism, '<sub>'))											    
	    	$symbolisism .= '</sub>';
		elseif (strpos($symbolisism, '<sup>'))											        	$symbolisism .= '</sup>';
		elseif (strpos($symbolisism, '<font '))											        	$symbolisism .= '</font>';
			
		return $symbolisism;
	}	
}

?>